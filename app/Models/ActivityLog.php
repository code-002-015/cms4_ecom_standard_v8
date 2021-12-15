<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class ActivityLog extends Model
{
    protected $table = 'cms_activity_logs';
    protected $fillable = ['log_by', 'activity_type', 'dashboard_activity', 'activity_desc', 'activity_date',
        'db_table', 'old_value', 'new_value', 'reference'];
    public $timestamps = false;

    public function admin()
    {
        return $this->belongsTo(User::class, 'log_by');
    }

    public static function getLogs($type,$id){
        $log = ActivityLog::where('id',$id)->first();

        switch($type){
            case 'update':
                return str_limit(str_replace(['<p>','</p>'],'',$log->activity_desc), 100, $end ='...');
                break;

            case 'update_content':
                return $log->activity_desc.' '.str_limit(str_replace(['<p>','</p>'],'',$log->old_value), 60, $end = '...').' to '.str_limit(str_replace(['<p>','</p>'],'',$log->new_value), 60, $end = '...');
                break;
            
            case 'delete' || 'restore':
                return $log->activity_desc;
                break;
            
            case 'insert':
                return $log->activity_desc;
                break;

            case 'insert_access' || 'update_access' || 'remove_access':
                return $log->activity_desc;
                break;
        }
    }
}
