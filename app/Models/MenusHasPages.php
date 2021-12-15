<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MenusHasPages extends Model
{
    use SoftDeletes;

    protected $table = 'menus_has_pages';
    protected $fillable = ['menu_id', 'parent_id', 'page_id', 'page_order', 'uri', 'label', 'target', 'type'];

    // public function menu()
    // {
    //     return $this->belongsTo(Menu::class);
    // }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id')->withTrashed();

//        if (\Auth::check()) {
//            return $this->belongsTo(Page::class, 'page_id', 'id');
//        } else {
//            return $this->belongsTo(Page::class, 'page_id', 'id')->where('status', 'PUBLISHED');
//        }
    }

    public function has_sub_menus()
    {
        $sub_menus = $this->sub_pages;
        if (!$sub_menus) {
            return false;
        }

        foreach($sub_menus as $sub_menu) {
            if ($sub_menu && $sub_menu->is_page_type() && $sub_menu->page && strtolower($sub_menu->page->status) == 'published') {
                return true;
                break;
            }

            if ($sub_menu->is_external_type()) {
                return true;
                break;
            }
        }
    }

    public function sub_pages()
    {
        return $this->hasMany(MenusHasPages::class, 'parent_id', 'id');
    }

	public function sub_pages_by_order()
    {
        return $this->sub_pages()->orderBy('page_order')->get();
    }

    public function parent_page()
    {
        return $this->hasOne(MenusHasPages::class, 'id', 'parent_id');
    }

    public function is_page_type()
    {
        return $this->type == "page";
    }

    public function is_external_type()
    {
        return $this->type == "external";
    }
    public function addPages($pages)
    {
        return $this->links()->createMany($pages);
    }

    private static function serialize()
    {
        $menuPages = json_decode(request('pages_json'), true);

        foreach ($menuPages as $index => $oneArray) {
            if (isset($oneArray['children'])) {
                foreach ($oneArray['children'] as $subIndex => $oneSubArray) {
                    if (isset($oneSubArray['children'])) {
                        foreach ($oneSubArray['children'] as $subSubIndex => $oneSubSubArray) {
                            $oneSubSubArray['page_order'] = $subSubIndex + 1;
                            $allPages[] = $oneSubSubArray;
                        }
                    }
                    unset($oneSubArray['children']);
                    $oneSubArray['page_order'] = $subIndex + 1;
                    $allPages[] = $oneSubArray;
                }
            }
            unset($oneArray['children']);
            $oneArray['page_order'] = $index + 1;
            $allPages[] = $oneArray;
        }

        return $allPages;
    }

    private static function validator()
    {
        // dd(MenusHasPages::serialize());
        return Validator::make([], [
            'id' => 'numeric|min:0',
            'parent_id' => 'numeric|min:0',
            'page_id' => 'required_if:id,0|numeric|min:0',
            'uri' => 'nullable|url',
            'page_order' => 'numeric',
            'target' => 'required_if:type,external',
            'type' => [
                Rule::in(['page', 'external']),
            ]
        ]);
    }

    public static function has_invalid_data()
    {
        return MenusHasPages::validator()->fails();
    }

    public static function get_error_messages()
    {
        return MenusHasPages::validator()->messages();
    }
}
