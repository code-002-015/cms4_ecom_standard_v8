<?php

namespace App\Models;

use App\Notifications\NewUserResetPasswordNotification;
use App\Notifications\UserResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Notifications\SendEmailNotificationCustomerWishlist;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'role_id', 'is_active', 'remember_token', 'firstname', 'lastname', 'avatar', 'user_id', 'isDeleted','mobile','phone','address_street','address_city','address_municipality','address_zip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return "$this->firstname $this->lastname";
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getAddressAttribute()
    {
        return $this->address_street.", ".$this->address_municipality.", ".$this->address_city.", ".$this->address_zip;
    }

    public function getRoleAttribute($value)
    {
        return strtoupper($value);
    }

    public function role_name()
    {
        return User::userRole($this->role_id);
    }

    public static function totalUser()
    {
        $total = User::where('is_active','=',1)->count();

        return $total;
    }

    public static function activeTotalUser()
    {
        // $total = User::where('role_id','<>',6)->where('is_active','=',1)->whereNotNull('email_verified_at')->count();
        $total = User::where('role_id','<>',6)->where('is_active','=',1)->count();

        return $total;
    }

    public static function inactiveTotalUser()
    {
        $total = User::where('role_id','<>',6)->where('is_active','=',0)->count();

        return $total;
    }

    public static function userEmail($id)
    {
        $data = User::where('id',$id)->first();

        return $data->email;
    }

    public static function userRole($id)
    {
        $data = Role::where('id',$id)->first();

        if (!$data) {
            return '';
        }

        return $data->name;
    }

    public function send_reset_password_email()
    {
        $token = app('auth.password.broker')->createToken($this);

        $this->notify(new UserResetPasswordNotification($token));
    }

    public function send_reset_temporary_password_email()
    {
        $token = app('auth.password.broker')->createToken($this);
        logger($token);
        $this->notify(new NewUserResetPasswordNotification($token));
    }

    public function send_email_notification_on_customer_wishlist($product)
    {
        $this->notify(new SendEmailNotificationCustomerWishlist($product));
    }

    public function has_access_to_pages_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[0]);
    }

    public function has_access_to_albums_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[1]);
    }

    public function has_access_to_file_manager_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[2]);
    }

    public function has_access_to_menu_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[3]);
    }

    public function has_access_to_news_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[4]);
    }

    public function has_access_to_news_categories_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[5]);
    }

    public function has_access_to_website_settings_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[6]);
    }

    public function has_access_to_audit_logs_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[7]);
    }

    public function has_access_to_user_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[8]);
    }

    public function has_access_to_product_category_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[9]);
    }

    public function has_access_to_product_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[10]);
    }

    public function has_access_to_subscriber_group_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[11]);
    }

    public function has_access_to_subscriber_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[12]);
    }

    public function has_access_to_campaign_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[13]);
    }

    public function has_access_to_mailing_list_sent_items_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[14]);
    }

    public function has_access_to_download_manager_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[15]);
    }

    public function has_access_to_download_manager_group_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[16]);
    }

    public function has_access_to_career_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[17]);
    }

    public function has_access_to_career_category_module()
    {
        return $this->has_access_to_module(array_keys(Permission::modules())[18]);
    }

    public function has_access_to_module($module)
    {
        if ($this->is_an_admin() == 1) {
            return true;
        }

        $routes = $this->get_module_routes($module);

        foreach($routes as $route) {
            if ($this->is_route_exist_to_user_permission($route)) {
                return true;
                break;
            }
        }

        return false;
    }

    private function get_module_routes($module)
    {
        return Permission::where('module', $module)->pluck('name');
    }

    private function is_route_exist_to_user_permission($route)
    {
        return \App\ViewPermissions::check_permission($this->role_id, $route) == 1;
    }

    public function has_access_to_route($route)
    {
        if ($this->is_an_admin()) {
            return true;
        }

        $userPermissionRoutes = $this->get_assigned_routes();

        if (in_array($route, $userPermissionRoutes)) {
            return true;
        }

        return false;
    }

    public function get_assigned_routes()
    {
        $permission = $this->assign_role->permissions;

        if ($permission) {
            return $permission->pluck('routes')->flatten()->all();
        }

        return [];
    }

    public function get_image_url_storage_path()
    {
        $delimiter = 'storage/';
        if (strpos($this->avatar, $delimiter) !== false) {
            $paths = explode($delimiter, $this->avatar);
            return $paths[1];
        }

        return '';
    }

    public function get_image_file_name()
    {
        $path = explode('/', $this->avatar);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }

    public function is_an_admin()
    {
        return $this->role_id == 1;
    }

    public function is_not_an_admin()
    {
        return $this->role_id != 1;
    }

    public function assign_role()
    {
        return $this->belongsTo(Role::class,'role_id', 'id');
    }




    // ******** AUDIT LOG ******** //
    // Need to change every model
    static $oldModel;
    static $tableTitle = 'user';
    static $name = 'name';
    static $unrelatedFields = ['id', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at'];
    static $logName = [
        'name' => 'name',
        'email' => 'email',
        'firstname' => 'firstname',
        'lastname' => 'lastname',
        'avatar' => 'avatar',
        'role_id' => 'role',
        'is_active' => 'status'

    ];
    // END Need to change every model

    public static function boot()
    {
        parent::boot();

        self::created(function($model) {
            $name = $model[self::$name];

            if(self::$logName['role_id'] <> 6){
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
            }
            
        });

        self::updating(function($model) {
            self::$oldModel = $model->fresh();
        });

        self::updated(function($model) {
            $name = $model[self::$name];

            if(self::$logName['role_id'] <> 6){
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
            }
        });

        self::deleted(function($model){
            $name = $model[self::$name];
            if(self::$logName['role_id'] <> 6){
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
            }
        });
    }
}
