<?php

namespace App\Http\Controllers\Cms4Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;
use App\Helpers\ModelHelper;

use App\Models\ArticleCategory;
use App\Models\Permission;

class ArticleCategoryController extends Controller
{
    private $searchFields = ['name'];

    public function __construct()
    {
        Permission::module_init($this, 'news_category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $categories = ListingHelper::simple_search(ArticleCategory::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.cms4.news.category_index',compact('categories','filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cms4.news.category_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newData = $this->validate_data($request);
        $newData['slug'] = ModelHelper::convert_to_slug(ArticleCategory::class, $newData['name']);
        $newData['user_id'] = auth()->id();

        ArticleCategory::create($newData);

        return redirect()->route('news-categories.index')->with('success', __('standard.news.category.create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param ArticleCategory $newsCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ArticleCategory $newsCategory)
    {
        return view('admin.cms4.news.category_edit',compact('newsCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ArticleCategory $newsCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleCategory $newsCategory)
    {
        $updateData = $this->validate_data($request);
        if (strtolower($updateData['name']) != strtolower($newsCategory->name)) {
            $updateData['slug'] = ModelHelper::convert_to_slug(ArticleCategory::class, $updateData['name']);
        }
        $updateData['user_id'] = auth()->id();

        $newsCategory->update($updateData);

        return back()->with('success', __('standard.news.category.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param ArticleCategory $newsCategory
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, ArticleCategory $newsCategory)
    {
        $newsCategory->update([ 'user_id' => auth()->user()->id ]);
        $newsCategory->delete();

        return back()->with('success', __('standard.news.category.delete_success'));
    }

    public function delete(Request $request)
    {
        //logger($request);
        $pages = explode("|",$request->pages);

        foreach($pages as $page){
            ArticleCategory::whereId($page)->update(['user_id' => auth()->user()->id ]);
            ArticleCategory::whereId($page)->delete();
        }

        return back()->with('success', __('standard.news.category.delete_success'));
    }

    public function restore($id){
        ArticleCategory::withTrashed()->find($id)->update(['user_id' => auth()->user()->id ]);
        ArticleCategory::whereId($id)->restore();

        return back()->with('success', __('standard.news.category.restore_success'));

    }

    public function get_slug(Request $request)
    {
        return ModelHelper::convert_to_slug(ArticleCategory::class, $request->url);
    }

    public function validate_data(Request $request)
    {
        return $request->validate([
            'name' => 'required|max:150',
        ]);
    }
}
