<?php

namespace App\Http\Controllers\Cms4Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\PageContactUsRequest;
use App\Http\Requests\PageCustomizeRequest;
use App\Http\Requests\PageStandardRequest;
use App\Http\Requests\PageDefaultRequest;
use App\Http\Requests\PagePost;

use Facades\App\Helpers\ListingHelper;
use Facades\App\Helpers\FileHelper;
use App\Helpers\Setting;
use App\Helpers\ModelHelper;

use App\Models\EmailRecipient;
use App\Models\Permission;
use App\Models\Category;
use App\Models\Article;
use App\Models\Album;
use App\Models\Menu;
use App\Models\Page;

use Response;
use Storage;
use Auth;


class PageController extends Controller
{
    private $searchFields = ['name'];
    private $advanceSearchFields = ['album_id', 'name', 'label', 'contents', 'status', 'meta_title', 'meta_keyword', 'meta_description', 'user_id', 'updated_at1', 'updated_at2'];

    public function __construct()
    {
        Permission::module_init($this, 1);
    }

    public function index(Request $request)
    {
        $pages = ListingHelper::simple_search(Page::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $advanceSearchData = ListingHelper::get_search_data($this->advanceSearchFields);
        $uniquePagesByAlbum = ListingHelper::get_unique_item_by_column(Page::class, 'album_id');
        $uniquePagesByUser = ListingHelper::get_unique_item_by_column(Page::class, 'user_id');

        $searchType = 'simple_search';

        return view('admin.cms4.pages.index', compact('pages', 'filter', 'advanceSearchData', 'uniquePagesByAlbum', 'uniquePagesByUser', 'searchType'));
    }

    public function advance_index(Request $request)
    {
        $equalQueryFields = ['album_id', 'status', 'user_id'];

        $pages = ListingHelper::advance_search(Page::class, $this->advanceSearchFields, $equalQueryFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $advanceSearchData = ListingHelper::get_search_data($this->advanceSearchFields);
        $uniquePagesByParent = ListingHelper::get_unique_item_by_column(Page::class, 'parent_id');
        $uniquePagesByAlbum = ListingHelper::get_unique_item_by_column(Page::class, 'album_id');
        $uniquePagesByUser = ListingHelper::get_unique_item_by_column(Page::class, 'parent_page_id');

        $searchType = 'advance_search';

        return view('admin.cms4.pages.index', compact('pages', 'filter', 'advanceSearchData', 'uniquePagesByParent', 'uniquePagesByAlbum', 'uniquePagesByUser', 'searchType'));
    }

    public function create()
    {
        $albums = Album::where('type', 'sub_banner')->get();
        $pages = Page::where('page_type', '=', 'standard')->get();

        return view('admin.cms4.pages.create', compact('albums', 'pages'));
    }


    public function store(PageStandardRequest $request)
    {
        $newData = $request->validated();
        $newData['album_id'] = empty($newData['album_id']) ? 0 : $newData['album_id'];
        $newData['parent_page_id'] = empty($newData['parent_page_id']) ? 0 : $newData['parent_page_id'];
        $newData['status'] = $request->has('visibility') ? 'PUBLISHED' : 'PRIVATE';
        $newData['page_type'] = 'standard';
        $newData['slug'] = ModelHelper::convert_to_slug(Page::class, $newData['name'], $newData['parent_page_id']);
        $newData['user_id'] = auth()->id();

        if ($request->hasFile('image_url')) {
            $newData['image_url'] = FileHelper::move_to_folder($request->file('image_url'), 'banners')['url'];
        }

        Page::create($newData);

        return redirect()->route('pages.index')->with('success', __('standard.pages.create_success'));
    }

    public function edit(Page $page)
    {
        $albums = Album::where('type', 'sub_banner')->get();
        $parentPages = Page::where('id', '!=', $page->id)->where('page_type', '=', 'standard')->get();
        $pageAlbum = $page->album;

        if ($page->is_contact_us_page()) {
            $settings = \App\Models\Setting::find(1);
            $emails = EmailRecipient::email_list_str();

            return view('admin.cms4.pages.contact-us', compact('page', 'parentPages', 'albums', 'pageAlbum', 'settings', 'emails'));
        } else if ($page->is_default_page()) {
            return view('admin.cms4.pages.default', compact('page'));
        } else if ($page->is_customize_page()) {
            return view('admin.cms4.pages.customize', compact('page', 'parentPages', 'albums', 'pageAlbum'));
        } else {
            return view('admin.cms4.pages.edit', compact('page', 'parentPages', 'albums', 'pageAlbum'));
        }
    }

    public function update(PageStandardRequest $request, Page $page)
    {
        $updateData = $request->validated();
        $updateData['album_id'] = empty($updateData['album_id']) ? 0 : $updateData['album_id'];
        $updateData['parent_page_id'] = empty($updateData['parent_page_id']) ? 0 : $updateData['parent_page_id'];
        $updateData['status'] = $request->has('visibility') ? 'PUBLISHED' : 'PRIVATE';
        $updateData['page_type'] = 'standard';
        $updateData['slug'] = $page->name == $updateData['name'] && $page->parent_page_id == $updateData['parent_page_id'] ?
                            $page->slug : ModelHelper::convert_to_slug(Page::class, $updateData['name'], $updateData['parent_page_id']);
        $updateData['user_id'] = auth()->id();

        if ($request->banner_type == 'banner_slider' || $request->has('delete_image')) {
            Storage::disk('public')->delete($page->get_image_url_storage_path());
            $updateData['image_url'] = '';
        }

        if ($request->hasFile('image_url')) {
            $updateData['image_url'] = FileHelper::move_to_folder($request->file('image_url'), 'banners')['url'];
        }

        $page->update($updateData);

        return back()->with('success', __('standard.pages.update_success'));
    }

    public function update_default(PageDefaultRequest $request, Page $page)
    {
        $updateData = $request->validated();
        $updateData['user_id'] = auth()->id();

        $page->update($updateData);

        return back()->with('success', __('standard.pages.update_success'));
    }

    public function update_customize(PageCustomizeRequest $request, Page $page)
    {
        $updateData = $request->validated();
        $updateData['album_id'] = empty($updateData['album_id']) ? 0 : $updateData['album_id'];
        $updateData['status'] = $request->has('visibility') ? 'PUBLISHED' : 'PRIVATE';
        $updateData['user_id'] = auth()->id();

        if ($request->banner_type == 'banner_slider' || $request->has('delete_image')) {
            Storage::disk('public')->delete($page->get_image_url_storage_path());
            $updateData['image_url'] = '';
        }

        if ($request->hasFile('image_url')) {
            $updateData['image_url'] = FileHelper::move_to_folder($request->file('image_url'), 'banners')['url'];
        }

        $page->update($updateData);

        return back()->with('success', __('standard.pages.update_success'));
    }

    public function update_contact_us(PageContactUsRequest $request, Page $page)
    {
        $updateData = $request->validated();
        $updateData['album_id'] = empty($updateData['album_id']) ? 0 : $updateData['album_id'];
        $updateData['status'] = $request->has('visibility') ? 'PUBLISHED' : 'PRIVATE';
        $updateData['user_id'] = auth()->id();

        if ($request->banner_type == 'banner_slider' || $request->has('delete_image')) {
            Storage::disk('public')->delete($page->get_image_url_storage_path());
            $updateData['image_url'] = '';
        }

        if ($request->hasFile('image_url')) {
            $updateData['image_url'] = FileHelper::move_to_folder($request->file('image_url'), 'banners')['url'];
        }

        $page->update($updateData);

        $settings = \App\Models\Setting::find(1);
        $settings->update([
            'contact_us_email_layout' => $updateData['content2']
        ]);

        $this->add_and_remove_email_recipients($updateData['emails']);

        return back()->with('success', __('standard.pages.update_success'));
    }

    public function destroy(Page $page)
    {
        if ($this->is_deletable($page) && $page->delete()) {
            return back()->with('success', __('standard.pages.delete_success'));
        } else {
            return back()->with('error', __('standard.pages.delete_failed'));
        }
    }

    public function show($id)
    {

    }

    public function get_slug(Request $request)
    {
        return Page::convert_to_slug($request->url, $request->parentPage);
    }

    public function check_if_slug_exists_on_update($url, $id)
    {
        $slug = Str::slug($url, '-');

        if (Page::where('slug', '=', $slug)->where('id', '<>', $id)->exists()) {
            return true;
        } elseif (Article::where('slug', '=', $slug)->exists()) {
            return true;
        } elseif (Category::where('slug', '=', $slug)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    public function view($slug)
    {
        $page = Page::where('slug', $slug)->first();
        $menu = Menu::where('is_active', 1)->first();
        $settings = Setting::info();

        $breadcrumb = $this->breadcrumb($page);


        return view('theme.'.env('FRONTEND_TEMPLATE').'.main', compact('page', 'breadcrumb', 'menu', 'settings'));
    }

    public function breadcrumb($page)
    {
        return [
            'home' => '/home',
            $page->name => '/page/'.$page->slug
        ];
    }

    public function search()
    {
        $params = Input::all();

        return $this->index($params);
    }

    public function change_status(Request $request)
    {
        $pages = explode("|", $request->pages);

        foreach ($pages as $page) {
            Page::where('status', '!=', $request->status)
            ->whereId($page)
            ->update([
                'status'  => $request->status,
                'user_id' => Auth::user()->id
            ]);
        }

        return back()->with('success', __('standard.pages.status_success', ['STATUS' => $request->status]));
    }

    public function delete(Request $request)
    {
        $pages = explode("|", $request->pages);

        foreach ($pages as $pageId) {
            $page = Page::find($pageId);

            if ($page && $this->is_deletable($page)) {
                $page->update([ 'user_id' => Auth::user()->id ]);
                $page->delete();
            }
        }

        return back()->with('success', __('standard.pages.delete_success'));
    }

    public function is_deletable($page)
    {
        return $page->page_type == 'standard';
    }

    public function restore($page)
    {
        Page::withTrashed()->find($page)->update(['user_id' => Auth::id() ]);
        Page::whereId($page)->restore();

        return back()->with('success', __('standard.pages.restore_success'));
    }

    public function add_and_remove_email_recipients($emails)
    {
        $emails = explode(',', $emails);
        EmailRecipient::whereNotIn('email', $emails)->delete();
        $registeredEmails = EmailRecipient::select('email')->pluck('email')->toArray();

        $newEmails = array_diff($emails, $registeredEmails);

        foreach ($newEmails as $email) {
            EmailRecipient::create(['email' => $email]);
        }
    }

    public function login_user_is_a_contributor()
    {
        return auth()->user()->role_id == 3;
    }

    public function upload_file_to_storage($folder, $file, $key = '')
    {
        $fileName = $file->getClientOriginalName();
        if (Storage::disk('public')->exists($folder.'/'.$fileName)) {
            $fileNames = explode(".", $fileName);
            $count = 2;
            $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
            while (Storage::disk('public')->exists($folder.'/'.$newFilename)) {
                $count += 1;
                $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
            }

            $fileName = $newFilename;
        }

        $path = Storage::disk('public')->putFileAs($folder, $file, $fileName);
        $url = Storage::disk('public')->url($path);
        $returnArr = [
            'name' => $fileName,
            'url' => $url
        ];

        if ($key == '') {
            return $returnArr;
        } else {
            return $returnArr[$key];
        }
    }

    public function check_parent_page_if_exist($parentPage)
    {
        return isset($parentPage) && $parentPage != null ? $parentPage : '0';
    }
}
