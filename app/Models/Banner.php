<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

use App\Models\ActivityLog;

class Banner extends Model
{
    use SoftDeletes;

    protected $table = 'banners';
    protected $fillable = ['album_id', 'title', 'description', 'alt','image_path', 'button_text', 'url', 'order', 'user_id'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public static function validator()
    {
        return Validator::make(request()->all(), [
            'banners.*.alt' => 'max:125',
            'banners.*.title' => 'max:65',
            'banners.*.button_text' => 'max:30',
            'banners.*.url' => 'nullable|url'
        ], [
            'banners.*.title.max' => 'The banner title should not be greater than 65 characters.',
            'banners.*.button_text.max' => 'The banner button text should not be greater than 30 characters.',
            'banners.*.alt.max' => 'The banner alt should not be greater than 125 characters.'
        ]);
    }

    public static function has_invalid_data()
    {
        return Banner::validator()->fails();
    }

    public static function get_error_messages()
    {
        return Banner::validator()->messages();
    }

    public static function totalBanners()
    {
        $total = Banner::count();

        return $total;
    }

    public function file_name()
    {
        $path = explode('/', $this->image_path);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }








    // ******** AUDIT LOG ******** //
    // Need to change every model
    static $oldModel;
    static $tableTitle = 'banner';
    static $name = 'name';
    static $unrelatedFields = ['id', 'alt', 'created_at', 'updated_at', 'deleted_at'];
    static $logName = [
        'album_id' => 'album',
        'title' => 'title',
        'description' => 'description',
        'image_path' => 'image url',
        'button_text' => 'button text',
        'url' => 'url',
        'order' => 'order'
    ];
    // END Need to change every model

    public static function boot()
    {
        parent::boot();

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
    }
}
