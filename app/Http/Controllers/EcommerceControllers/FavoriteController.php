<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Facades\App\Helpers\ListingHelper;

use App\Models\CustomerFavorite;
use App\Models\CustomerWishlist;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Page;

use Auth;



class FavoriteController extends Controller
{
    private $searchFields = ['product_name'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ListingHelper::simple_search(Favorite::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.ecommerce.product-favorite.index',compact('products', 'filter','searchType'));
    }


    public function index_front()
    {
        $products = CustomerFavorite::where('customer_id',Auth::id())->get();

        $page = new Page();
        $page->name = 'My Favorites';

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.ecommerce.favorites',compact('products','page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }

    public function add_to_cart($productid){

        $product = Product::find($productid);

        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $productid,
            'qty' => 1,
            'price' => $product->price
        ]);

        return back()->with('success','Product added to cart.');
    }

    public function btn_add_to_favorites(Request $request)
    {
        $data = Favorite::where('product_id',$request->product_id);
        $product = Product::find($request->product_id);

        if($data->count() > 0){
            $wishlist = $data->first();

            Favorite::where('product_id',$request->product_id)->increment('total_count',1);

            $qry = CustomerFavorite::where('customer_id',Auth::id())->where('product_id',$product->id)->exists();
            if(!$qry){
                CustomerFavorite::create([
                    'customer_id' => Auth::id(),
                    'product_id' => $product->id
                ]);
            }

            return response()->json([
                'success' => true,               
            ]);

        } else {
            Favorite::create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'total_count' => 1
            ]);

            CustomerFavorite::create([
                'customer_id' => Auth::id(),
                'product_id' => $product->id
            ]);

            return response()->json([
                'success' => true,               
            ]);
        }
    }

    public function remove_product(Request $request){

        $qry = Favorite::where('product_id',$request->productid)->decrement('total_count',1);

        if($qry){
            $qry2 = Favorite::where('product_id',$request->productid)->first();

            if($qry2->total_count == 0){
                Favorite::where('product_id',$request->productid)->delete();
            }

            CustomerFavorite::where('customer_id', Auth::id())->where('product_id',$request->productid)->delete();
        }

        return back()->with('success','Successfully removed.');
    }

    public function btn_remove_to_favorites(Request $request){

        $qry = Favorite::where('product_id',$request->product_id)->decrement('total_count',1);

        if($qry){
            $qry2 = Favorite::where('product_id',$request->product_id)->first();

            if($qry2->total_count == 0){
                Favorite::where('product_id',$request->product_id)->delete();
            }

            CustomerFavorite::where('customer_id', Auth::id())->where('product_id',$request->product_id)->delete();
            return response()->json([
                'success' => true,               
            ]);
        }
    }

    public function add_to_wishlist($productid)
    {
        CustomerWishlist::create([
            'customer_id' => Auth::id(),
            'product_id' => $productid
        ]);

        return back()->with('success','Product has been added to wishlist.');

    }

}
