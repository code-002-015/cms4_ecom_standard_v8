<?php

namespace App\Http\Controllers\EcommerceControllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Facades\App\Helpers\ListingHelper;

use App\Models\ProductCategory;
use App\Models\Permission;
use App\Models\Page;

use \Carbon\Carbon;
use Auth;

class ProductCategoryController extends Controller
{
    private $searchFields = ['name'];

    public function __construct()
    {
        Permission::module_init($this, 'product_category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listing = ListingHelper::required_condition('id', '<>', 87);
        $categories = $listing->simple_search(ProductCategory::class, $this->searchFields);

        // Simple search init data
        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.ecommerce.products.category_index',compact('categories', 'filter', 'searchType'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productCategories = ProductCategory::all();

        return view('admin.ecommerce.products.category_create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required|min:3|max:1000'
            ])->validate();

        $slug = Page::convert_to_slug($request->name);

        ProductCategory::create([
            'parent_id' => $request->parent_page,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'status' => (isset($request->visibility) ? 'PUBLISHED' : 'PRIVATE'),
            'created_by' => Auth::id(),
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('product-categories.index')->with('success', __('standard.products.category.create_category_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);

        $productCategories = ProductCategory::all();

        return view('admin.ecommerce.products.category_edit',compact('category', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|min:3|max:1000'
        ])->validate();

        $productCategory = ProductCategory::findOrFail($id);

        if($productCategory->name == $request->name){
            $slug = $productCategory->slug;
        }
        else{
            $slug = \App\Page::convert_to_slug($request->name);
        }

        $productCategory->update([
            'name' => $request->name,
            'parent_id' => $request->parent_page,
            'slug' => $slug,
            'status' => (isset($request->visibility) ? 'PUBLISHED' : 'PRIVATE'),
            'description' => $request->description,
            'created_by' => auth()->user()->id
        ]);

        return redirect()->route('product-categories.index')->with('success', __('standard.products.category.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function restore($category){
        ProductCategory::withTrashed()->find($category)->update(['created_by' => Auth::id() ]);
        ProductCategory::whereId($category)->restore();

        return back()->with('success', __('standard.products.category.restore_category_success'));
    }

    public function get_slug(Request $request)
    {
        return Page::convert_to_slug($request->url, $request->parentPage);
    }

    public function single_delete(Request $request)
    {
        $category = ProductCategory::findOrFail($request->categories);
        $category->update([ 'created_by' => Auth::id() ]);
        $category->delete();

        return back()->with('success', __('standard.products.category.single_delete_success'));

    }

    public function multiple_delete(Request $request)
    {
        $categories = explode("|",$request->categories);

        foreach($categories as $category){
            ProductCategory::whereId($category)->update(['created_by' => Auth::id() ]);
            ProductCategory::whereId($category)->delete();
        }

        return back()->with('success', __('standard.products.category.multiple_delete_success'));
    }

    public function update_status($id,$status)
    {
        ProductCategory::where('id',$id)->update([
            'status' => $status,
            'created_by' => Auth::id()
        ]);

        return back()->with('success', __('standard.products.category.category_update_success', ['STATUS' => $status]));
    }

    public function multiple_change_status(Request $request)
    {
        $categories = explode("|", $request->categories);

        foreach ($categories as $category) {
            $publish = ProductCategory::where('status', '!=', $request->status)->whereId($category)->update([
                'status'  => $request->status,
                'created_by' => Auth::id()
            ]);
        }

        return back()->with('success',  __('standard.products.category.category_update_success', ['STATUS' => $request->status]));
    }
}
