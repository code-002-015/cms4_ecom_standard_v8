<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

use App\Models\ActivityLog;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';
    protected $fillable = ['name', 'is_active', 'pages_json'];

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'menus_has_pages');
    }

    public function navigation()
    {
        return $this->hasMany(MenusHasPages::class);
    }

    // public function addPages($pages)
    // {
    //     return $this->links()->createMany($pages);
    // }

    public function parent_navigation()
    {
        return $this->navigation()->where('parent_id', 0)->orderBy('page_order')->get();
    }

    private static function validator()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|max:150',
            'is_active' => 'numeric|digits_between:0,1',
            'pages_json' => 'required|JSON'
        ], [
            'pages_json.required' => 'Please add atleast one item in the menu.',
        ]);
    }

    public static function has_invalid_data()
    {
        return Menu::validator()->fails();
    }

    public static function get_error_messages()
    {
        return Menu::validator()->messages();
    }



    



    // ******** AUDIT LOG ******** //
    // Need to change every model
    static $oldModel;
    static $tableTitle = 'menu';
    static $name = 'name';
    static $unrelatedFields = ['id', 'created_at', 'updated_at', 'deleted_at'];
    static $logName = [
        'name' => 'name',
        'pages_json' => 'menu order',
        'is_active' => 'is active'
    ];
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
    }
}
