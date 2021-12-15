<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Role;

use App\Models\ActivityLog;

class Permission extends Model
{
    use SoftDeletes;

    public $table = 'permission';

    protected $fillable = [ 'name', 'module', 'description', 'routes', 'methods', 'user_id', 'is_view_page'];

    protected $casts = [
        'routes' => 'array',
        'methods' => 'array',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission')->where('isAllowed', 1);
    }

    public function module_code()
    {
        return implode("_", explode(' ', $this->module));
    }

    public static function module_init($controller, $moduleName)
    {
        $permissions = Permission::where('module', $moduleName)->get();

        foreach ($permissions as $permission) {
            $controller->middleware('checkAccessRights:'.$permission->id, ['only' => $permission->methods]);
        }
    }

    public static function has_access_to_route($routeId)
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

    public static function modules()
    {
        return [
            'page' => 'Pages',
            'banner' => 'Banners',
            'file_manager' => 'Files',
            'menu' => 'Menu',
            'news' => 'News',
            'news_category' => 'News Category',
            'website_settings' => 'Website Settings',
            'audit_logs' => 'Audit Trail',
            'user' => 'Users',
        ];
    }










    // ******** AUDIT LOG ******** //
    // Need to change every model
    static $oldModel;
    static $tableTitle = 'permission';
    static $name = 'name';
    static $unrelatedFields = ['id', 'routes', 'methods', 'is_view_page', 'created_at', 'updated_at', 'deleted_at'];
    static $logName = [
        'name' => 'name',
        'module' => 'module',
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
    }
}
