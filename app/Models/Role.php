<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ActivityLog;

class Role extends Model
{
    use SoftDeletes;

    public $table = 'role';

    protected $fillable = [ 'name', 'description', 'created_by',];

    public function is_admin() {
        return $this->id == 1;
    }

    public function is_not_admin() {
        return $this->id != 1;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission')->where('isAllowed', 1);
    }

    public static function has_permission_to_route($routeId)
    {
        if (auth()->check())
        {
            $userPermissions = auth()->user()->assign_role->permissions;
            if ($userPermissions->count())
            {
                $permissionIds = $userPermissions->pluck('id')->toArray();

                return (in_array($routeId, $permissionIds));
            }
        }

        return false;
    }







    // ******** AUDIT LOG ******** //
    // Need to change every model
    static $oldModel;
    static $tableTitle = 'role';
    static $name = 'name';
    static $unrelatedFields = ['id', 'created_at', 'updated_at', 'deleted_at'];
    static $logName = [
        'name' => 'name',
        'description' => 'description',
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
