<?php

namespace App\Http\Controllers\Cms4Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;

use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;
use Facades\App\Helpers\FileHelper;
use App\Helpers\ModelHelper;

use App\Models\ArticleCategory;
use App\Models\Permission;
use App\Models\Article;

use Response;
use Storage;
use Auth;
use DB;

class ArticleController extends Controller
{
    private $searchFields = ['name'];
    private $advanceSearchFields = ['teaser', 'is_featured', 'name', 'contents', 'status', 'meta_title', 'meta_keyword', 'meta_description', 'user_id', 'category_id', 'updated_at1', 'updated_at2'];
    private $sortFields = ['updated_at', 'name', 'is_featured'];

    public function __construct()
    {
        Permission::module_init($this, 'news');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $news = ListingHelper::sort_by('is_featured')
            ->filter_fields($this->sortFields)
            ->simple_search(Article::class, $this->searchFields);

        $filter = ListingHelper::filter_fields($this->sortFields)->get_filter($this->searchFields);

        $advanceSearchData = ListingHelper::get_search_data($this->advanceSearchFields);
        $uniqueNewsByCategory = ListingHelper::get_unique_item_by_column(Article::class, 'category_id');
        $uniqueNewsByUser = ListingHelper::get_unique_item_by_column(Article::class, 'user_id');

        $searchType = 'simple_search';

        return view('admin.cms4.news.index', compact('news', 'filter', 'advanceSearchData', 'uniqueNewsByCategory', 'uniqueNewsByUser', 'searchType'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function advance_index(Request $request)
    {
        $equalQueryFields = ['album_id', 'category_id', 'status', 'user_id'];

        $news = ListingHelper::sort_by('is_featured')
            ->filter_fields($this->sortFields)
            ->advance_search(Article::class, $this->advanceSearchFields, $equalQueryFields);

        $filter = ListingHelper::filter_fields($this->sortFields)->get_filter($this->searchFields);

        $advanceSearchData = ListingHelper::get_search_data($this->advanceSearchFields);
        $uniqueNewsByCategory = ListingHelper::get_unique_item_by_column(Article::class, 'category_id');
        $uniqueNewsByUser = ListingHelper::get_unique_item_by_column(Article::class, 'user_id');

        $searchType = 'advance_search';

        return view('admin.cms4.news.index', compact('news', 'filter', 'advanceSearchData', 'uniqueNewsByCategory', 'uniqueNewsByUser', 'searchType'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $categories = ArticleCategory::all();
        return view('admin.cms4.news.create', compact('categories'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        $newData = $request->validated();

        $newData['slug'] = ModelHelper::convert_to_slug(Article::class, $newData['name']);
        $newData['status'] = $request->has('visibility') ? 'Published' : 'Private';
        $newData['image_url'] = $request->hasFile('news_image') ? FileHelper::move_to_folder($request->file('news_image'), 'news_image')['url'] : null;
        $newData['thumbnail_url'] = $request->hasFile('news_thumbnail') ? FileHelper::move_to_folder($request->file('news_thumbnail'), 'news_image/news_thumbnail')['url'] : null;
        $newData['is_featured'] = Article::can_set_featured() && $request->has('is_featured');
        $newData['user_id'] = auth()->id();

        Article::create($newData);

        return redirect()->route('news.index')->with('success', __('standard.news.article.create_success'));
    }

    /**
     * @param Request $request
     * @param Article $news
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Article $news)
    {
        $categories = ArticleCategory::all();

        return view('admin.cms4.news.edit', compact('news', 'categories'));
    }


    /**
     * @param Request $request
     * @param Article $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, Article $news)
    {
        $updateData = $request->validated();

        $updateData['slug'] = $news->name != $updateData['name'] ? ModelHelper::convert_to_slug(Article::class, $updateData['name']) : $news['slug'];
        $updateData['status'] = $request->has('visibility') ? 'Published' : 'Private';
        $updateData['is_featured'] = $news->is_featured ? $request->has('is_featured') : Article::can_set_featured() && $request->has('is_featured');
        $updateData['user_id'] = auth()->id();

        if (isset($request->delete_image) || $request->hasFile('news_image')) {
            FileHelper::delete_file($news->get_image_url_storage_path());
            $updateData['image_url'] = null;
            if ($request->hasFile('news_image')) {
                $updateData['image_url'] = FileHelper::move_to_folder($request->file('news_image'), 'news_image')['url'];
            }
        }

        if (isset($request->delete_thumbnail) || $request->hasFile('news_thumbnail')) {
            FileHelper::delete_file($news->get_thumbnail_url_storage_path());
            $updateData['thumbnail_url'] = null;
            if ($request->hasFile('news_thumbnail')) {
                $updateData['thumbnail_url'] = FileHelper::move_to_folder($request->file('news_thumbnail'), 'news_image/news_thumbnail')['url'];
            }
        }

        $news->update($updateData);

        return back()->with('success', __('standard.news.article.update_success'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change_status(Request $request)
    {
        $pages = explode("|", $request->pages);

        foreach ($pages as $page) {
            Article::where('status', '!=', $request->status)
            ->whereId($page)
            ->update([
                'status' => $request->status
            ]);
        }

        return back()->with('success', __('standard.news.article.status_success', ['STATUS' => $request->status]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $pages = explode("|", $request->pages);

        foreach ($pages as $page) {
            $news = Article::whereId($page);
            $news->update(['status' => 'PRIVATE']);
            $news->delete();
        }

        return back()->with('success', __('standard.news.article.delete_success'));
    }

    public function restore($page)
    {
        Article::whereId($page)->restore();

        return back()->with('success', __('standard.news.article.restore_success'));
    }

    public function get_slug(Request $request)
    {
        return ModelHelper::convert_to_slug(Article::class, $request->url);
    }
}
