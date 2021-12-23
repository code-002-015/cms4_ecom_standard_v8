@extends('theme.ecommerce.main')

@section('pagecss')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="content-wrap">
	<div class="container">
		@if($message = Session::get('cart_success'))
		<div class="alert alert-success">
			<i class="icon-cart"></i><strong>Success!</strong> {{$message}}
		</div>
		@endif

		<table class="table cart mb-5">
			<thead>
				<tr>
					<th class="cart-product-remove">&nbsp;</th>
					<th class="cart-product-thumbnail">&nbsp;</th>
					<th class="cart-product-name">Product</th>
					<th class="cart-product-price">Unit Price</th>
					<th class="cart-product-quantity">Quantity</th>
					<th class="cart-product-subtotal">Total</th>
				</tr>
			</thead>
			<tbody>
				@php 
                    $grandtotal = 0; $totalproducts = 0; $available_stock = 0; 

                    $cproducts  = '';
                    $totalCartProducts = 0;
                @endphp

                @forelse($cart as $key => $order)

	                @php 
	                    $totalproducts += 1;
	                    $grandtotal += $order->product->discountedprice*$order->qty;

	                    if($order->product->inventory == 0){
	                        $available_stock++;
	                    }


	                    $cproducts .= $order->product_id.'|';
	                    $totalCartProducts++;

	                    if(Auth::check()){
	                    	$orderID = $order->id;
	                    } else {
	                    	$orderID = $key;
	                    }
	                @endphp
					<tr class="cart_item">
						@if(Auth::check())
                            <input type="hidden" name="cart_id[]" value="{{ $order->id }}">
                        @else
                            <input type="hidden" name="cart_id[]" value="{{$order->product_id}}">
                        @endif

						<td class="cart-product-remove">
							<a href="#" onclick="remove_item('{{$orderID}}')" class="remove" title="Remove this item"><i class="icon-trash2"></i></a>
						</td>

						<td class="cart-product-thumbnail">
							<a href="#"><img width="64" height="64" src="{{ asset('storage/products/'.$order->product->photoPrimary) }}" alt="{{ $order->product->name }}"></a>
						</td>

						<td class="cart-product-name">
							<a href="{{ route('product.front.show',$order->product->slug)}}">{{ $order->product->name }}</a>
						</td>

						<td class="cart-product-price">
							<span class="amount">₱{{ number_format($order->product->discountedprice,2) }}</span>
						</td>

						<td class="cart-product-quantity">
							<div class="quantity">
								<input type="button" value="-" class="minus">
								<input type="text" name="quantity[]" class="qty" value="{{$order->qty}}" id="order{{$orderID}}_qty" onchange="order_qty('{{$orderID}}')"/>
								<input type="button" value="+" class="plus">


								<input type="hidden" id="orderID_{{$orderID}}" value="{{$order->product_id}}">
								<input type="hidden" id="prevqty{{$orderID}}" value="{{ $order->qty }}">
								<input type="hidden" id="maxorder{{$orderID}}" value="{{ $order->product->inventory }}">
							</div>
						</td>

						<td class="cart-product-subtotal">
							<input type="hidden" name="product_price[]" id="input_order{{$orderID}}_product_price" value="{{$order->product->discountedprice}}">
                            <input type="hidden" class="input_product_total_price" data-id="{{$orderID}}" data-productid="{{$order->product_id}}" id="input_order{{$orderID}}_product_total_price" value="{{$order->product->discountedprice*$order->qty}}">

							<span class="amount" id="order{{$orderID}}_total_price">₱{{ number_format($order->product->discountedprice*$order->qty,2) }}</span>
						</td>
					</tr>
				@empty
					@php $totalproducts = 0; @endphp
					<tr class="cart_item">
						<td colspan="6" class="text-center">Your shopping cart is <strong>empty</strong>.</td>
					</tr>
				@endforelse


				<!-- coupon discounts -->
                <input type="hidden" id="coupon_total_discount" name="coupon_total_discount" value="0">
                <input type="hidden" id="total_amount_discount" value="0">

                <input type="hidden" name="grantotal" id="npt_grandTotal" value="{{ $grandtotal }}">
			</tbody>
		</table>

		<div class="row col-mb-30">
			<div class="col-lg-6">
				<div class="col-lg-auto ps-lg-0">
					<div class="row">
						<div class="col-md-8">
							<input type="text" value="" class="sm-form-control text-center text-md-start" placeholder="Enter Coupon Code.." />
						</div>
						<div class="col-md-4 mt-3 mt-md-0">
							<a href="#" class="button button-3d button-black m-0">Apply Coupon</a>
						</div>
					</div>
					<a href="#">Click here to view coupons</a>
				</div>

				<br><br>
				<div id="couponDiv">
                    <div class="coupon-item p-2 border rounded mb-1">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <div class="coupon-item-name">
                                    <h5 class="m-0">CPN 001<span></span></h5>
                                </div>
                                <div class="coupon-item-desc small mb-1">
                                    <span>description</span>
                                </div>
                                <div class="coupon-item-btns">
                                    <button type="button" class="btn btn-danger btn-sm cRmvFreeProduct" id="1">Remove</button>&nbsp;
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="terms and conditions">Terms & Conditions</button>
                                </div>
                            </div>
                        </div>
                    </div>
               	</div>
			</div>

			<div class="col-lg-6">
				<h4>Cart Totals</h4>

				<div class="table-responsive">
					<table class="table cart cart-totals">
						<tbody>
							<tr class="cart_item">
								<td class="cart-product-name">
									<strong>Cart Subtotal</strong>
								</td>

								<td class="cart-product-name">
									<span class="amount" id="subtotal">₱{{ number_format($grandtotal,2) }}</span>
								</td>
							</tr>
							<tr class="cart_item">
								<td class="cart-product-name">
									<strong>Shipping</strong>
								</td>

								<td class="cart-product-name">
									<span class="amount">Free Delivery</span>
								</td>
							</tr>
							<tr class="cart_item">
								<td class="cart-product-name">
									<strong>Total</strong>
								</td>

								<td class="cart-product-name">
									<span class="amount color lead"><strong id="grandtotal">₱{{ number_format($grandtotal,2) }}</strong></span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row justify-content-end py-2 col-mb-30">
					<div class="col-lg-auto pe-lg-0">
						<a href="{{ route('cart.front.checkout') }}" class="button button-3d mt-2 mt-sm-0 me-0">Proceed to Checkout</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="display: none;">
    <form id="remove_order_form" method="post" action="{{route('cart.remove_product')}}">
        @csrf
        <input type="text" name="order_id" id="order_id" value="">
    </form>
</div>
@endsection


@section('pagejs')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

	<script>

		$(document).ready(function(){
			$('[data-toggle="popover"]').popover();
		});
	


		function FormatAmount(number, numberOfDigits) {

	        var amount = parseFloat(number).toFixed(numberOfDigits);
	        var num_parts = amount.toString().split(".");
	        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

	        return num_parts.join(".");
	    }

	    function order_qty(id){
	    	var qty = $('#order'+id+'_qty').val();
	    	var price = $('#input_order'+id+'_product_price').val();

	    	total_price  = parseFloat(price)*parseFloat(qty);

			$('#order'+id+'_total_price').html('₱'+FormatAmount(total_price,2));
			$('#input_order'+id+'_product_total_price').val(total_price);


			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

			console.log(qty);
            $.ajax({
                data: { 
                    "quantity": qty, 
                    "orderID": id, 
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('cart.update')}}",
                
                success: function(returnData) {

                    // var promo_discount = parseFloat(returnData.total_promo_discount);
                    // $('#span_promo_discount').html(addCommas(promo_discount.toFixed(2)));
                    // $('#promo_total_discount').val(promo_discount.toFixed(2));
                    // $('#subtotal').val(returnData.subtotal);

                    // $('#couponList').empty();
                    // $('#manual-coupon-details').empty();
                    // $('.prod_new_price').hide();
                    // $('#coupon_counter').val(0);
                    // $('#solo_coupon_counter').val(0);
                    // $('#total_amount_discount_counter').val(0);
                    // $('#coupon_total_discount').val(0);

                    // $('#total_amount_discount').val(0);
                    // $('.couponDiscountDiv').hide();



                    // $(".cart_product_reward").each(function() {
                    //     $(this).val(0);
                    // });

                    // $(".cart_product_discount").each(function() {
                    //     $(this).val(0);
                    // });

                    cart_total();
                }
            });
	    }

	    function cart_total(){
	        var couponTotalDiscount = parseFloat($('#coupon_total_discount').val());
	        var totalAmount = 0;

	        $(".input_product_total_price").each(function() {
	            if(!isNaN(this.value) && this.value.length!=0) {
	                totalAmount += parseFloat(this.value);
	            }
	        });
	        
	        // if(couponTotalDiscount == 0){
	        //     $('.couponDiscountSummary').css('display','none');
	        // }

	        var grandtotal = totalAmount-couponTotalDiscount;
	        
	        $('#subtotal').html('₱'+FormatAmount(totalAmount,2));
	        $('#grandtotal').html('₱'+FormatAmount(grandtotal,2));
	        $('#npt_grandTotal').val(grandtotal);

	    }

	    function remove_item(id){
	        swal({
	            title: 'Are you sure?',
	            text: "This will remove the item from your cart",
	            icon: 'warning',
	            showCancelButton: true,
	            confirmButtonColor: '#d33',
	            cancelButtonColor: '#3085d6',
	            confirmButtonText: 'Yes, remove it!'            
	        },
	        function(isConfirm) {
	            if (isConfirm) {
	                $('#order_id').val(id);
	                $('#remove_order_form').submit();
	            } 
	            else {                    
	                swal.close();                   
	            }
	        });
	    }
	</script>
@endsection