<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';
    protected $fillable = ['parent_page_id', 'album_id', 'slug', 'name', 'label', 'contents', 'status', 'page_type', 'image_url', 'meta_title', 'meta_keyword', 'meta_description', 'user_id', 'template'];

    // public function album()
    // {
    //     return $this->belongsTo(Album::class);
    // }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menus_has_pages');
    }

    public function parent_page()
    {
        return $this->hasOne(Page::class, 'id', 'parent_page_id')->where('status', 'PUBLISHED');
    }

    public function has_parent_page()
    {
        return $this->parent_page && $this->parent_page->count() > 0;
    }

    public function sub_pages()
    {
        return $this->hasMany(Page::class, 'parent_page_id')->where('status', 'PUBLISHED');
    }

    public function has_sub_pages()
    {
        return $this->sub_pages && $this->sub_pages->count() > 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class)->withDefault([
            'name' => 'No album',
            'id' => '0',
        ]);
    }

    public function has_slider()
    {
        return empty($this->image_url);
    }

    public function is_published()
    {
        return strtolower($this->status) == 'published';
    }

    public function is_customize_page()
    {
        return $this->page_type == 'customize';
    }

    public function is_home_page()
    {
        return $this->id == 1;
    }

    public function is_contact_us_page()
    {
        return $this->id == 3;
    }

    public function is_standard_page()
    {
        return $this->page_type == 'standard';
    }

    public function is_not_standard_page()
    {
        return $this->page_type != 'standard';
    }

    public function is_default_page()
    {
        return $this->page_type == 'default';
    }

    public function is_not_default_page()
    {
        return $this->page_type != 'default';
    }

    public function get_url()
    {
        return env('APP_URL')."/".$this->slug;
    }

    public static function totalPages()
    {
        $total = Page::withTrashed()->get()->count();

        return $total;
    }

    public static function totalPublicPages()
    {
        $total = Page::where('status','PUBLISHED')->count();

        return $total;
    }

    public static function totalPrivatePages()
    {
        $total = Page::where('status','PRIVATE')->count();

        return $total;
    }

    public static function totalDeletePages()
    {
        $withTrashed = Page::withTrashed()->get()->count();
        $total = $withTrashed - Page::count();
        return $total;
    }

    public static function convert_to_slug($url, $parentPage = 0){
        $url = str_slug($url, '-');

        $parentPage = Page::find($parentPage);
        if($parentPage) {
            $url = $parentPage->slug.'/'.$url;
        }

        if(self::check_if_slug_exists($url)){
            $url=$url.'-2';
            return self::convert_to_slug($url);
        }
        else{
            return $url;
        }
    }

    public static function check_if_slug_exists($slug){

        if (Page::where('slug', '=', $slug)->exists()) {
            return true;
        }
        elseif (Article::where('slug', '=', $slug)->exists()) {
            return true;
        }
        elseif (ArticleCategory::where('slug', '=', $slug)->exists()) {
            return true;
        }
        else{
            return false;
        }
    }

    public function get_image_url_storage_path()
    {
        $delimiter = 'storage/';
        if (strpos($this->image_url, $delimiter) !== false) {
            $paths = explode($delimiter, $this->image_url);
            return $paths[1];
        }

        return '';
    }

    public function get_image_file_name()
    {
        $path = explode('/', $this->image_url);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }

    public static function page_not_found()
    {
        $view404 = 'theme.'.env('FRONTEND_TEMPLATE').'.pages.404';
        if (view()->exists($view404)) {
            $page = new Page();
            $page->name = 'Page not found';
            return view($view404, compact('page'));
        }

        return abort(404);
    }















    // ******** AUDIT LOG ******** //
    // Need to change every model
    static $oldModel;
    static $tableTitle = 'page';
    static $name = 'name';
    static $unrelatedFields = ['id', 'slug', 'page_type', 'created_at', 'updated_at', 'deleted_at'];
    static $logName = [
        'parent_page_id' => 'parent page',
        'album_id' => 'banner',
        'banner' => 'banner',
        'name' => 'name',
        'label' => 'label',
        'contents' => 'contents',
        'status' => 'status',
        'image_url' => 'image', 
        'meta_title' => 'meta title',
        'meta_keyword' => 'meta keywords',
        'meta_description' => 'meta description',
        'is_published' => 'visibility'
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

        self::restored(function($model){
            $name = $model[self::$name];
            ActivityLog::create([
                'log_by' => auth()->id(),
                'activity_type' => 'restore',
                'dashboard_activity' => 'restore a '. self::$tableTitle,
                'activity_desc' => 'restore the '. self::$tableTitle .' '. $name,
                'activity_date' => date("Y-m-d H:i:s"),
                'db_table' => $model->getTable(),
                'old_value' => '',
                'new_value' => '',
                'reference' => $model->id
            ]);
        });
    }
}
