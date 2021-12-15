<?php

namespace App\Http\Controllers\EcommerceControllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Facades\App\Helpers\ListingHelper;

use App\Http\Requests\ProductRequest;


use App\Models\ProductCategory;
use App\Models\ProductPhoto;
use App\Models\ProductTag;
use App\Models\Product;
use App\Models\Permission;
use App\Models\Page;

use Storage;
use Auth;



class ProductController extends Controller
{
    private $searchFields = ['name'];
    private $advanceSearchFields = ['category_id', 'name', 'brand', 'short_description', 'description', 'status', 'price1', 'price2', 'user_id', 'updated_at1', 'updated_at2'];

    public function __construct()
    {
        Permission::module_init($this, 'product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listing = ListingHelper::required_condition('status', '!=', 'UNEDITABLE');
        $products = $listing->simple_search(Product::class, $this->searchFields);

        // Simple search init data
        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';

        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniqueProductByCategory = $listing->get_unique_item_by_column(Product::class, 'category_id');
        $uniqueProductByBrand = $listing->get_unique_item_by_column(Product::class, 'brand');
        $uniqueProductByUser = $listing->get_unique_item_by_column(Product::class, 'created_by');

        return view('admin.ecommerce.products.index',compact('products', 'filter', 'searchType','uniqueProductByCategory','uniqueProductByBrand','uniqueProductByUser','advanceSearchData'));

    }

    public function advance_index(Request $request)
    {
        $customConditions = [
            [
                'field' => 'status',
                'operator' => '!=',
                'value' => 'UNEDITABLE',
                'apply_to_deleted_data' => true
            ]
        ];

        $equalQueryFields = ['category_id', 'status', 'created_by','brand'];

        $listing = new ListingHelper( 'desc', 10, 'updated_at', $customConditions);
        $products = $listing->advance_search('App\EcommerceModel\Product', $this->advanceSearchFields, $equalQueryFields);

        $filter = $listing->get_filter($this->searchFields);

        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniqueProductByCategory = $listing->get_unique_item_by_column('App\EcommerceModel\Product', 'category_id');
        $uniqueProductByBrand = $listing->get_unique_item_by_column('App\EcommerceModel\Product', 'brand');
        $uniqueProductByUser = $listing->get_unique_item_by_column('App\EcommerceModel\Product', 'created_by');

        $searchType = 'advance_search';

        return view('admin.ecommerce.products.index',compact('products', 'filter', 'searchType','uniqueProductByCategory','uniqueProductByBrand','uniqueProductByUser','advanceSearchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('name','asc')->get();

        return view('admin.ecommerce.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $zoom_image = '';


        $slug = Page::convert_to_slug($request->name);

        $product = Product::create([
            'code' => $request->code,
            'category_id' => $request->category,
            'name' => $request->name,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'description' => $request->long_description,
            'brand' => $request->brand,
            'reorder_point' => $request->reorder_point,
            'currency' => 'PHP',
            'price' => $request->price,
            'size' => $request->size,
            'weight' => $request->weight,
            'status' => ($request->has('status') ? 'PUBLISHED' : 'PRIVATE'),
            'is_featured' => $request->has('is_featured'),
            'uom' => $request->uom,
            'meta_title' => $request->seo_title,
            'meta_keyword' => $request->seo_keywords,
            'meta_description' => $request->seo_description,
            'zoom_image' => $zoom_image,
            'created_by' => Auth::id(),
        ]);

        if($request->hasFile('zoom_image'))
        {
            $newFile = $this->upload_file_to_storage('zoom_image/'.$product->id, $request->file('zoom_image'));
            $zoom_image = $newFile['url'];
        }

        $this->tags($product->id, $request->tags);

        $newPhotos = $this->set_order(request('photos'));
        $productPhotos = $this->move_product_to_official_folder($product->id, $newPhotos);

        $this->delete_temporary_product_folder();

        foreach ($productPhotos as $key => $photo) {
            ProductPhoto::create([
                'product_id' => $product->id,
                'name' => (empty($photo['name']) ? '' : $photo['name']),
                'description' => '',
                'path' => $photo['image_path'],
                'status' => 'PUBLISHED',
                'is_primary' => ($key == $request->is_primary) ? 1 : 0,
                'created_by' => Auth::id()
            ]);
        }


        return redirect()->route('products.index')->with('success', __('standard.products.product.create_success'));

        //return $request;
    }

    public function tags($id,$tags)
    {
        foreach(explode(',',$tags) as $tag)
        {
            ProductTag::create([
                'product_id' => $id,
                'tag' => $tag,
                'created_by' => Auth::id()
            ]);
        }
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
        $product = Product::findOrFail($id);
        $categories = ProductCategory::orderBy('name','asc')->get();

        return view('admin.ecommerce.products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {

        $product = Product::findOrFail($id);

        $zoom_image = $product->zoom_image;
        if (isset($request->delete_zoom)) {
            $zoom_image = '';
        }

        if($request->hasFile('zoom_image'))
        {
            $newFile = $this->upload_file_to_storage('zoom_image/'.$id, $request->file('zoom_image'));
            $zoom_image = $newFile['url'];
        }
//        $colors = ProductVariation::colors($id);
//        $sizes  = ProductVariation::sizes($id);

        if($product->name == $request->name){
            $slug = $product->slug;
        }
        else{
            $slug = \App\Page::convert_to_slug($request->name);
        }

        $product->update([
            'code' => $request->code,
            'category_id' => $request->category,
            'name' => $request->name,
            'brand' => $request->brand,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'description' => $request->long_description,
            'currency' => 'PHP',
            'price' => $request->price,
            'reorder_point' => $request->reorder_point,
            'size' => $request->size,
            'weight' => $request->weight,
            'status' => ($request->has('status') ? 'PUBLISHED' : 'PRIVATE'),
            'is_featured' => $request->has('is_featured'),
            'uom' => $request->uom,
            'zoom_image' => $zoom_image,
            'meta_title' => $request->seo_title,
            'meta_keyword' => $request->seo_keywords,
            'meta_description' => $request->seo_description,
            'created_by' => Auth::id()
        ]);



        $this->update_tags($product->id,$request->tags);

        $photos = $this->set_order(request('photos'));

        $this->update_photos($this->get_product_photos($photos));

        $this->remove_photos_from_product(request('remove_photos'));

        $newPhotos = $this->get_new_photos($photos);

        $newPhotos = $this->move_product_to_official_folder($product->id, $newPhotos);

        foreach ($newPhotos as $key => $photo) {
            ProductPhoto::create([
                'product_id' => $product->id,
                'name' => (empty($photo['name']) ? '' : $photo['name']),
                'description' => '',
                'path' => $photo['image_path'],
                'status' => 'PUBLISHED',
                'is_primary' => ($key == $request->is_primary) ? 1 : 0,
                'created_by' => Auth::id()
            ]);
        }

        return redirect()->route('products.edit', $product->id)->with('success', __('standard.products.product.update_success'));
    }

    public function update_photos($photos)
    {
        foreach ($photos as $photo) {
            if ($photo) {
                $photo['name'] = ($photo['name']) ? $photo['name'] : '';
                ProductPhoto::find($photo['id'])->update($photo);
            }
        }
    }

    public function update_tags($id,$tags)
    {
        $delete = ProductTag::where('product_id',$id)->forceDelete();

        if($delete){
            foreach(explode(',',$tags) as $tag){
                ProductTag::create([
                    'product_id' => $id,
                    'tag' => $tag,
                    'created_by' => Auth::id()
                ]);
            }
        }

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

    public function get_slug(Request $request)
    {
        return Page::convert_to_slug($request->url, $request->parentPage);
    }

    public function restore($id)
    {
        Product::withTrashed()->find($id)->update(['created_by' => Auth::id() ]);
        Product::whereId($id)->restore();

        return back()->with('success', __('standard.products.product.restore_product_success'));
    }

    public function change_status($id,$status)
    {
        Product::where('id',$id)->update([
            'status' => $status,
            'created_by' => Auth::id()
        ]);

        return back()->with('success', __('standard.products.product.update_status_success', ['STATUS' => $status]));
    }

    public function single_delete(Request $request)
    {
        $product = Product::findOrFail($request->products);
        $product->update([ 'created_by' => Auth::id() ]);
        $product->delete();

        return back()->with('success', __('standard.products.product.single_delete_success'));

    }

    public function multiple_change_status(Request $request)
    {
        $products = explode("|", $request->products);

        foreach ($products as $product) {
            $publish = Product::where('status', '!=', $request->status)->whereId($product)->update([
                'status'  => $request->status,
                'created_by' => Auth::id()
            ]);
        }

        return back()->with('success',  __('standard.products.product.change_status_success', ['STATUS' => $request->status]));
    }

    public function multiple_delete(Request $request)
    {
        $products = explode("|",$request->products);

        foreach($products as $product){
            Product::whereId($product)->update(['created_by' => Auth::id() ]);
            Product::whereId($product)->delete();
        }

        return back()->with('success', __('standard.products.product.multiple_delete_success'));
    }

// save files to temporary folder
    public function upload(Request $request)
    {
        if ($request->hasFile('banner')) {

            $newFile = $this->upload_file_to_temporary_storage($request->file('banner'));

            return response()->json([
                'status' => 'success',
                'image_url' => $newFile['url'],
                'image_name' => $newFile['name'],
                'image_path' => $newFile['path'],
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'image_url' => '',
            'image_name' => ''
        ]);
    }

    public function get_product_photos($photos)
    {
        return array_filter($photos, function ($photo) {
            return isset($photo['id']);
        });
    }

    public function get_new_photos($photos)
    {
        return array_filter($photos, function ($photo) {
            return !isset($photo['id']);
        });
    }

    public function remove_photos_from_product($photos)
    {
        ProductPhoto::find($photos ?? [])->each(function ($photo, $key) {
            $imagePath = $this->get_banner_path_in_storage($photo->image_path);
            Storage::disk('public')->delete($imagePath);
            $photo->update(['user_id' => auth()->id()]);
            $photo->delete();

        });
    }

    public function upload_file_to_temporary_storage($file)
    {
        $temporaryFolder = 'temporary_products'.auth()->id();
        $fileName = $file->getClientOriginalName();
        if (Storage::disk('public')->exists($temporaryFolder.'/'.$fileName)) {
            $fileName = $this->make_unique_file_name($temporaryFolder, $fileName);
        }

        $path = Storage::disk('public')->putFileAs($temporaryFolder, $file, $fileName);
        $url = Storage::disk('public')->url($path);

        return [
            'path' => $temporaryFolder.'/'.$fileName,
            'name' => $fileName,
            'url' => $url
        ];
    }
//

// move uploaded product files to official product folder
    public function delete_temporary_product_folder()
    {
        $temporaryFolder = 'temporary_products'.auth()->id();
        Storage::disk('public')->deleteDirectory($temporaryFolder);
    }

    public function set_order($products = [])
    {
        $products = $products ?? [];

        $count = 1;
        foreach($products as $key => $product) {
            $products[$key]['order'] = $count;
            $count += 1;
        }

        return $products;
    }

    public function move_product_to_official_folder($productId, $products)
    {
        foreach ($products as $key => $product) {
            $temporaryPath = $this->get_banner_path_in_storage($products[$key]['image_path']);
            $fileName = $this->get_banner_file_name($products[$key]['image_path']);
            $bannerFolder = '';

            $products[$key]['image_path'] = $this->move_to_products_folder($productId, $temporaryPath, $bannerFolder.$fileName);
        }

        return $products;
    }

    public function get_banner_path_in_storage($path)
    {
        $paths = explode('storage/', $path);

        if (count($paths) == 1) {
            return '';
        }

        return explode('storage/', $path)[1];
    }

    public function get_banner_file_name($path)
    {
        $temporaryFolder = 'temporary_products'.auth()->id();
        return explode($temporaryFolder, $path)[1];
    }

    public function move_to_products_folder($id,$temporaryPath, $fileName)
    {
        $folder = 'products/'.$id;
        if (Storage::disk('public')->exists($folder.$fileName)) {
            $fileName = $this->make_unique_file_name($folder, $fileName);
        }

        $newPath = $folder.$fileName;
        Storage::disk('public')->move($temporaryPath, $newPath);
        return $id.$fileName;
    }

    public function make_unique_file_name($folder, $fileName)
    {
        $fileNames = explode(".", $fileName);
        $count = 2;
        $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
        while(Storage::disk('public')->exists($folder.'/'.$newFilename)) {
            $count += 1;
            $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
        }

        return $newFilename;
    }

    public function upload_file_to_storage($folder, $file, $key = '') {

        $fileName = $file->getClientOriginalName();
        if (Storage::disk('public')->exists($folder.'/'.$fileName)) {
            $fileNames = explode(".", $fileName);
            $count = 2;
            $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
            while(Storage::disk('public')->exists($folder.'/'.$newFilename)) {
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
//

}
