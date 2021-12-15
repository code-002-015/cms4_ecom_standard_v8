<?php

namespace App\Http\Controllers\EcommerceControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Facades\App\Helpers\ListingHelper;

use App\Models\CustomerWishlist;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Page;

use Auth;


class WishlistController extends Controller
{
    private $searchFields = ['product_name'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ListingHelper::simple_search(Wishlist::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.ecommerce.product-wishlist.index',compact('products', 'filter','searchType'));
    }

    public function index_front()
    {
        $products = CustomerWishlist::where('customer_id',Auth::id())->get();

        $page = new Page();
        $page->name = 'My Wishlist';

        return view('theme.'.env('FRONTEND_TEMPLATE').'.pages.ecommerce.wishlist',compact('products','page'));
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
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }

    public function add_to_wishlist(Request $request){

        $data = Wishlist::where('product_id',$request->product_id);
        $product = Product::find($request->product_id);

        if($data->count() > 0){
            $wishlist = $data->first();

            Wishlist::where('product_id',$request->product_id)->increment('total_count',1);

            $qry = CustomerWishlist::where('customer_id',Auth::id())->where('product_id',$product->id)->exists();
            if(!$qry){
                CustomerWishlist::create([
                    'customer_id' => Auth::id(),
                    'product_id' => $product->id
                ]);
            }

            return response()->json([
                'success' => true,               
            ]);

        } else {
            Wishlist::create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'total_count' => 1
            ]);

            CustomerWishlist::create([
                'customer_id' => Auth::id(),
                'product_id' => $product->id
            ]);

            return response()->json([
                'success' => true,               
            ]);
        }
    }

    public function remove_to_wishlist(Request $request){

        $qry = Wishlist::where('product_id',$request->product_id)->decrement('total_count',1);

        if($qry){
            $qry2 = Wishlist::where('product_id',$request->product_id)->first();

            if($qry2->total_count == 0){
                Wishlist::where('product_id',$request->product_id)->delete();
            }

            CustomerWishlist::where('customer_id', Auth::id())->where('product_id',$request->product_id)->delete();
            return response()->json([
                'success' => true,               
            ]);
        }
    }

    public function remove_product(Request $request){

        $qry = Wishlist::where('product_id',$request->productid);

        if($qry->decrement('total_count',1)){
            $data = $qry->first();
            if($data->total_count == 0){
                $qry->delete();
            }

            CustomerWishlist::where('customer_id', Auth::id())->where('product_id',$request->productid)->delete();
        }

        return back()->with('success','Successfully removed.');
    }

    public function add_to_cart($productid){

        $product = Product::find($productid);

        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $productid,
            'qty' => 1,
            'price' => $product->price
        ]);

        $qry = Wishlist::where('product_id',$productid);

        if($qry->decrement('total_count',1)){
            $data = $qry->first();
            if($data->total_count == 0){
                $qry->delete();
            }
        }

        CustomerWishlist::where('customer_id', Auth::id())->where('product_id',$productid)->delete();

        return back()->with('success','Product added to cart.');
    }
}
