<?php

namespace App\Http\Controllers\EcommerceControllers\Product\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Page;
use DB;
use Illuminate\Support\Facades\Auth;

class ProductFrontController extends Controller
{
    public function shop()
    {
        dd('asasa');
    }


    public function show($slug)
    {
        $sales_history = 0;
        if(Auth::guest()) {
            $product = Product::whereSlug($slug)->where('status', 'PUBLISHED')->first();
        } else {
            $product = Product::whereSlug($slug)->where('status', '!=', 'UNEDITABLE')->first(); 
            $sales_history = $this->checkIfUserPurchasedTheItem($product->id);      
          
        }

        $page = $product;
        if (empty($product)) {
            abort(404);
        }


        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.product.profile',compact('product', 'page','sales_history'));
    }

    public function checkIfUserPurchasedTheItem($id){

        $rs = DB::select("SELECT d.*                  
                    FROM `ecommerce_sales_details` d 
                    left join ecommerce_sales_headers h on h.id=d.sales_header_id 
                    where d.product_id='".$id."' and h.user_id='".Auth::id()."'
                     ");

        if (empty($rs)) {
            return 0;
        }else{
            return 1;
        }

    }

    public function show_forsale(){

        $products = DB::table('products')->where('for_sale', '1')->where('status','PUBLISHED')->where('for_sale_web','1')->where('is_misc','0')->select('name')->distinct()->get();
        $miscs = DB::table('products')->where('for_sale', '1')->where('status','PUBLISHED')->where('for_sale_web','1')->where('is_misc','1')->select('name')->distinct()->get();

        $page = new Page();
        $page->name = 'Order';

        // $d = '';
        // foreach($products as $product){
        //     $main = Product::info($product->name);
        //     if(empty($main)){
        //         $d.=$product->name."<br>";
        //     }
        // }
        // return $d;
        return view('theme.'.env('FRONTEND_TEMPLATE').'.ecommerce.product.order',compact('products','page','miscs'));

    }
    

    public function list(Request $request)
    {
        $page = new Page();
        $page->name = 'Order';
        $pageLimit = 40;

        if($request->has('search')){
            $products = Product::whereStatus('PUBLISHED');

            if(!empty($request->searchtxt)){  
                $searchtxt = $request->searchtxt;      
                $products = $products->where(function($query) use ($searchtxt){
                        $query->where('name','like','%'.$searchtxt.'%')
                            ->orWhere('description','like','%'.$searchtxt.'%');
                        });
            }

            if(!empty($request->category)){            
                $products = $products->whereIn('category_id',$request->category);
            }

            if(!empty($request->brand)){            
                $products = $products->whereIn('brand',$request->brand);
            }

            if(!empty($request->price)){

                $priceConditions = '';
                foreach($request->price as $price){
                    $range = explode("-", $price);
                    $priceConditions.=' or (price>='.$range[0].' and price<='.$range[1].')';
                }
                $priceConditions = "(".ltrim($priceConditions," or").")";
                $products = $products->whereRaw($priceConditions);
            
                
            }

            if(!empty($request->sort)){            
                if($request->sort == 'Price low to high'){
                    $products = $products->orderBy('price','asc');
                }
                elseif($request->sort == 'Price high to low'){
                    $products = $products->orderBy('price','desc');
                }
            }

            if(!empty($request->limit)){ 
                if($request->limit=='All')
                    $pageLimit = 100000000;      
                else
                    $pageLimit = $request->limit;
            }
            $total_product = $products->count();
            $products = $products->orderBy('name','asc')->paginate($pageLimit);
        }
        else{
            $products = Product::whereStatus('PUBLISHED')
                ->orderBy('name','asc')
                ->orderBy('id','asc')
                ->paginate($pageLimit);
            $total_product = Product::whereStatus('PUBLISHED')
                ->orderBy('name','asc')
                ->orderBy('id','asc')->count();
        }
        /* End Search function */

        // Product Categories
        $categories = ProductCategory::select('id', 'name')->where('parent_id', 0)->where('status', 'PUBLISHED')->orderBy('name')->get();

        $brands = Product::whereNotNull('brand')->distinct()->orderBy('brand')->get(['brand']);

        $product = Product::where('status', 'PUBLISHED')->where(function($model) {
            $model->orWhere('category_id', null);
            $model->orWhere('category_id', 0);
        })->orderBy('name')->count();

        if ($product) {
            $uncategorized = new ProductCategory();
            $uncategorized->id = 0;
            $uncategorized->name = "Uncategorized";
            $uncategorized->child_categories = null;

            $categories->push($uncategorized);

            $categories = $categories->sortBy(function ($category, $key) {
                return strtolower($category->name);
            });
        }
        // End Product Categories

        return view('theme.ecommerce.pages.product-list',compact('brands','products','categories','total_product','page','request'));

    }

  
    public function get_sub_categories_ids($ids, $categories)
    {
        $categoryIds = $categories->pluck('id');
        $ids = array_merge($ids, $categoryIds->toArray());
        foreach ($categoryIds as $id) {
            $subCategory = ProductCategory::find($id);
            $subSubCategories = $subCategory->child_categories;
            if ($subSubCategories && $subSubCategories->count()) {
                $ids = $this->get_sub_categories_ids($ids, $subSubCategories);
            }
        }

        return $ids;
    }

    public function categories($conditions=null){

        if($conditions){

        }
        else{
            $categories = DB::select('SELECT ifnull(c.name, "Uncategorized") as cat, ifnull(c.id,0) as cid,count(ifnull(c.id,0)) as total_products FROM `products` a left join product_categories c on c.id=a.category_id where a.deleted_at is null and a.status="PUBLISHED" GROUP BY c.name,c.id ORDER BY c.name');


            $data = '<ul class="listing-category">';
            foreach($categories as $category) {
                $ul2 = '';
                if ($category->child_categories) {
                    $ul2 = '<ul>';
                    $ul3 = '';
                }
                $data .= '<li><a href="#" onclick="filter_category('.$category->id.')">'.$category->name.'</a><li>';
            }
            $data .= '</ul>';
        }

        return $data;
    }
}
