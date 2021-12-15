<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

use App\Models\ActivityLog;

class Album extends Model
{
    use SoftDeletes;

    protected $table = 'albums';
    protected $fillable = ['name', 'transition_in', 'transition_out', 'transition', 'type', 'banner_type', 'user_id'];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class)->orderBy('order');
    }

    public function addBanners($banners)
    {
        foreach ($banners as $key => $banner) {
            $banners[$key]['user_id'] = auth()->id();
        }

        return $this->banners()->createMany($banners);
    }

    public function animationIn()
    {
        return $this->belongsTo(Option::class, 'transition_in');
    }

    public function animationOut()
    {
        return $this->belongsTo(Option::class, 'transition_out');
    }

    public function is_main_banner()
    {
        return $this->type == 'main_banner';
    }

    private static function validator()
    {
        $minBanner = (request()->has('banner_type') && request()->banner_type == 'video') ? 1 : 1;

        return Validator::make(request()->all(), [
            'name' => 'required|max:150',
            'transition_in' => 'required',
            'transition_out' => 'required',
            'transition' => 'required|numeric|min:2|max:10',
            'banner_type' => '',
            'banners' => 'required|array|min:'.$minBanner
        ], [
            'banners.required' => 'Please upload at least '. $minBanner .' banner.',
        ], [
            'name' => 'Album name'
        ]);
    }

    private static function quick_edit_validator()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|max:150',
            'transition_in' => 'required',
            'transition_out' => 'required',
            'transition' => 'required|numeric|min:2|max:10'
        ]);
    }

    public static function has_invalid_data()
    {
        return Album::validator()->fails();
    }

    public static function has_invalid_quick_edit_data()
    {
        return Album::quick_edit_validator()->fails();
    }

    public static function get_error_messages()
    {
        return Album::validator()->messages();
    }

    public static function get_quick_edit_error_messages()
    {
        return Album::quick_edit_validator()->messages();
    }

    public function path()
    {
        return '/albums/' . $this->id;
    }

    public static function totalAlbums()
    {
        $total = Album::where('type','sub_banner')->withTrashed()->get()->count();

        return $total;
    }

    public static function totalNotDeletedAlbums()
    {
        $total = Album::where('type','sub_banner')->count();

        return $total;
    }

    public static function totalDeletePages()
    {
        $withTrashed = Album::withTrashed()->get()->count();
        $total = $withTrashed - Album::count();

        return $total;
    }










    // ******** AUDIT LOG ******** //
    // Need to change every model
    static $oldModel;
    static $tableTitle = 'album';
    static $name = 'name';
    static $unrelatedFields = ['id', 'type', 'banner_type', 'created_at', 'updated_at', 'deleted_at'];
    static $logName = [
        'name' => 'name',
        'transition_in' => 'transition-in',
        'transition_out' => 'transition-out',
        'transition' => 'transation duration',    ];
    // END Need to change every model

    public static function boot()
    {
        parent::boot();

        self::created(function($model) {
            $name = $model[self::$name];

            ActivityLog::create([
                'log_by' => auth()->id(),
                'activity_type' => 'insert',
                'dashboard_activity' => 'created a new '. self::$tableTitle,
                'activity_desc' => 'created the '. self::$tableTitle .' '. $name,
                'activity_date' => date("Y-m-d H:i:s"),
                'db_table' => $model->getTable(),
                'old_value' => '',
                'new_value' => $name,
                'reference' => $model->id
            ]);
        });

        self::updating(function($model) {
            self::$oldModel = $model->fresh();
        });

        self::updated(function($model) {
            $name = $model[self::$name];
            $oldModel = self::$oldModel->toArray();
            foreach ($oldModel as $fieldName => $value) {
                if (in_array($fieldName, self::$unrelatedFields)) {
                    continue;
                }

                $oldValue = $model[$fieldName];
                if ($oldValue != $value) {
                    ActivityLog::create([
                        'log_by' => auth()->id(),
                        'activity_type' => 'update',
                        'dashboard_activity' => 'updated the '. self::$tableTitle .' '. self::$logName[$fieldName],
                        'activity_desc' => 'updated the '. self::$tableTitle .' '. self::$logName[$fieldName] .' of '. $name .' from '. $oldValue .' to '. $value,
                        'activity_date' => date("Y-m-d H:i:s"),
                        'db_table' => $model->getTable(),
                        'old_value' => $oldValue,
                        'new_value' => $value,
                        'reference' => $model->id
                    ]);
                }
            }
        });

        self::deleted(function($model){
            $name = $model[self::$name];
            ActivityLog::create([
                'log_by' => auth()->id(),
                'activity_type' => 'delete',
                'dashboard_activity' => 'deleted a '. self::$tableTitle,
                'activity_desc' => 'deleted the '. self::$tableTitle .' '. $name,
                'activity_date' => date("Y-m-d H:i:s"),
                'db_table' => $model->getTable(),
                'old_value' => '',
                'new_value' => '',
                'reference' => $model->id
            ]);
        });

        // self::restored(function($model){
        //     $name = $model[self::$name];
        //     ActivityLog::create([
        //         'log_by' => auth()->id(),
        //         'activity_type' => 'restore',
        //         'dashboard_activity' => 'restore a '. self::$tableTitle,
        //         'activity_desc' => 'restore the '. self::$tableTitle .' '. $name,
        //         'activity_date' => date("Y-m-d H:i:s"),
        //         'db_table' => $model->getTable(),
        //         'old_value' => '',
        //         'new_value' => '',
        //         'reference' => $model->id
        //     ]);
        // });
    }
}
