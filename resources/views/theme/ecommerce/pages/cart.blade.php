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
		<form method="post" action="{{ route('cart.front.proceed_checkout') }}">
			@csrf
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



	                            <!-- Coupon Inputs -->
	                            <input type="hidden" class="cart_product_reward" id="cart_product_reward{{$orderID}}" value="0">
	                            <input type="hidden" class="cart_product_discount" id="cart_product_discount{{$orderID}}" value="0">

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
								<input type="text" value="" id="coupon_code" class="sm-form-control text-center text-md-start" placeholder="Enter Coupon Code.." />
							</div>
							<div class="col-md-4 mt-3 mt-md-0">
								<button type="button" class="button button-3d button-black m-0" id="couponManualBtn">Apply Coupon</button>
							</div>
						</div>
						@if(Auth::check())
	                    <a href="#" onclick="myCoupons()"> Click here to view coupons</a>
	                    @else
	                    <a href="#" onclick="login_modal()"> Click here to view coupons</a>
	                    @endif
					</div>

					<br><br>
					<div id="couponList"></div>
					<div id="discount_list"></div>
	               	<div id="manual-coupons"></div>

	               	<input type="hidden" id="coupon_limit" value="{{ Setting::info()->coupon_limit }}">
	                <input type="hidden" id="coupon_counter" name="coupon_counter" value="0">
	                <input type="hidden" id="solo_coupon_counter" value="0">
	                <input type="hidden" id="total_amount_discount_counter" value="0">
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
								<tr class="cart_item" id="couponDiscountDiv" style="display: none;">
									<td class="cart-product-name">
										<strong>Coupon Discount</strong>
									</td>

									<td class="cart-product-name">
										<span class="amount" id="total_coupon_deduction">₱0.00</span>
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
							<button type="submit" class="button button-3d mt-2 mt-sm-0 me-0">Proceed to Checkout</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@include('theme.ecommerce.pages.modal')

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
	


		function FormatAmount(number, numberOfDigits) {

	        var amount = parseFloat(number).toFixed(numberOfDigits);
	        var num_parts = amount.toString().split(".");
	        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

	        return num_parts.join(".");
	    }

	    function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
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

            $.ajax({
                data: { 
                    "quantity": qty, 
                    "orderID": id, 
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('cart.update')}}",
                
                success: function(returnData) {

                    var promo_discount = parseFloat(returnData.total_promo_discount);
                    //$('#span_promo_discount').html(addCommas(promo_discount.toFixed(2)));
                    //$('#promo_total_discount').val(promo_discount.toFixed(2));

                    let subtotal = 0;
                    $(".input_product_total_price").each(function() {
			            if(!isNaN(this.value) && this.value.length!=0) {
			                subtotal += parseFloat(this.value);
			            }
			        });

                    $('#subtotal').val(subtotal);

                    $('#couponList').empty();
                    $('#manual-coupons').empty();
                    //$('.prod_new_price').hide();
                    $('#coupon_counter').val(0);
                    $('#solo_coupon_counter').val(0);
                    $('#total_amount_discount_counter').val(0);
                    $('#coupon_total_discount').val(0);

                    $('#total_amount_discount').val(0);
                    $('#couponDiscountDiv').css('display','none');



                    $(".cart_product_reward").each(function() {
                        $(this).val(0);
                    });

                    $(".cart_product_discount").each(function() {
                        $(this).val(0);
                    });

                    cart_total();
                }
            });
	    }

	    function cart_total(){
	        var couponTotalDiscount = parseFloat($('#coupon_total_discount').val());
	        var promoTotalDiscount = 0;
	        var subtotal = 0;

	        $(".input_product_total_price").each(function() {
	            if(!isNaN(this.value) && this.value.length!=0) {
	                subtotal += parseFloat(this.value);
	            }
	        });


	        
	        if(couponTotalDiscount == 0){
	            $('#couponDiscountSummary').css('display','none');
	        }

	        var totalDeduction = promoTotalDiscount+couponTotalDiscount;
	        var grandtotal = subtotal-totalDeduction;
	        
	        $('#subtotal').html('₱'+FormatAmount(subtotal,2));
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

	<!-- Coupon JS -->
	<script>

		function myCoupons(){
            var hasProduct = $('#cproducts').val();
            if(hasProduct == ''){
                swal({
                    title: '',
                    text: "Your shopping cart is empty. Please add at least one (1) product.",         
                });
                return false;
            }

            let totalAmount = 0;  
            $(".input_product_total_price").each(function() {
	            if(!isNaN(this.value) && this.value.length!=0) {
	                totalAmount += parseFloat(this.value);
	            }
	        });

	        let totalQty = 0;
	        $(".qty").each(function() {
	            if(!isNaN(this.value) && this.value.length!=0) {
	                totalQty += parseFloat(this.value);
	            }
	        });

            $.ajax({
                type: "GET",
                url: "{{ route('display.collectibles') }}",
                data: {
                    'total_amount' : totalAmount,
                    'total_qty' : totalQty,
                    'page_name' : 'cart',
                },
                success: function( response ) {
                    $('#collectibles').empty();

                    // array selected coupon : used to check if coupon is already selected
                        var arr_selected_coupons = [];
                        $("input[name='couponid[]']").each(function() {
                            arr_selected_coupons.push(parseInt($(this).val()));
                        });
                    //

                    // array cart product id, brand, category
                        var arr_cart_products = [];
                        $("input[name='productid[]']").each(function() {
                            arr_cart_products.push(parseInt($(this).val()));
                        });

                        var arr_cart_brands = [];
                        $("input[name='productbrand[]']").each(function() {
                            if($(this).val() != ''){
                                arr_cart_brands.push($(this).val());
                            }
                        });

                        var arr_cart_categories = [];
                        $("input[name='productcatid[]']").each(function() {
                            arr_cart_categories.push(parseInt($(this).val()));
                        });
                    //

                    $.each(response.coupons, function(key, coupon) {
                        // coupon validity label
                            if(coupon.end_date == null){
                                var validity = '';  
                            } else {
                                if(coupon.end_time == null){
                                    var validity = ' - Valid Till '+coupon.end_date;
                                } else {
                                    var validity = ' - Valid Till '+coupon.end_date+' '+coupon.end_time;
                                }
                            }
                        //
                        

                        if(jQuery.inArray(coupon.id, response.availability) !== -1){ 
                            // condition
                                if(jQuery.inArray(coupon.id, arr_selected_coupons) !== -1){
                                	console.log('checkx');
                                    var usebtn = '<button class="btn btn-success btn-sm" disabled>Applied</button>';
                                } else {
                                    if(coupon.amount_discount_type == 1){
                                    	console.log('check');
                                        var qty_counter = 0;
                                        if(coupon.free_product_id != null){
                                            qty_counter++;
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="free_product_coupon('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        } else {
                                            qty_counter++;
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_total_amount('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        }
                                    } else {
                                    	console.log('checks');
                                        if(coupon.product_discount == 'current'){
                                            // products
                                                if(coupon.purchase_product_id != null){

                                                    var product_counter = 0;
                                                    var arr_purchase_products = [];
                                                    var product_split = coupon.purchase_product_id.split('|');

                                                    // check if customer buys product under set products
                                                    $.each(product_split, function(key, productID) {
                                                        if(productID != ''){
                                                            arr_purchase_products.push(parseInt(productID));    
                                                        }
                                                        
                                                        if(jQuery.inArray(parseInt(productID), arr_cart_products) !== -1){
                                                            product_counter++;
                                                        }
                                                    });

                                                    if(product_counter > 0){
                                                        var qty_counter = 0;
                                                        // each cart product
                                                        $.each(arr_cart_products, function(key, product) {

                                                            if(jQuery.inArray(parseInt(product), arr_purchase_products) !== -1){
                                                                var iteration = $('#iteration'+parseInt(product)).val();
                                                                var product_qty = $('#quantity'+iteration).val();
                                                                // total amount purchase

                                                                // total qty purchase
                                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                                if(product_qty > parseFloat(coupon.purchase_qty)){
                                                                    qty_counter++;
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            //

                                            // product categories
                                                if(coupon.purchase_product_cat_id != null){
                                                    var category_counter = 0;
                                                    var arr_purchase_categories = [];
                                                    var category_split = coupon.purchase_product_cat_id.split('|');

                                                    // check if customer buys product under set category
                                                    $.each(category_split, function(key, value) {
                                                        if(value != ''){
                                                            arr_purchase_categories.push(parseInt(value));    
                                                        }
                                                        
                                                        if(jQuery.inArray(parseInt(value), arr_cart_categories) !== -1){
                                                            category_counter++;
                                                        }
                                                    });

                                                    if(category_counter > 0){
                                                        var qty_counter = 0;
                                                        // each cart category
                                                        $.each(response.cart_per_category, function(key, category) {

                                                            if(jQuery.inArray(parseInt(category), arr_purchase_categories) !== -1){
                                                                var category_qty = response.cart_qty_per_category[key];
                                                                // total amount purchase

                                                                // total qty purchase
                                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                                if(category_qty > parseFloat(coupon.purchase_qty)){
                                                                    qty_counter++;
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            //

                                            // product brands
                                                if(coupon.purchase_product_brand != null){
                                                    var brand_counter = 0;
                                                    var arr_purchase_brands = [];
                                                    var brand_split = coupon.purchase_product_brand.split('|');

                                                    // check if customer buys product under set category
                                                    $.each(brand_split, function(key, brand) {
                                                        if(brand != ''){
                                                            arr_purchase_brands.push(brand);    
                                                        }
                                                        
                                                        if(jQuery.inArray(brand, response.cart_per_brand) !== -1){
                                                            brand_counter++;
                                                        }
                                                    });

                                                    if(brand_counter > 0){
                                                        var qty_counter = 0;
                                                        // each cart brand
                                                        $.each(response.cart_per_brand, function(key, brand) {

                                                            if(jQuery.inArray(brand, arr_purchase_brands) !== -1){
                                                                var brand_qty = response.cart_qty_per_brand[key];
                                                                // total amount purchase

                                                                // total qty purchase
                                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                                if(brand_qty > parseFloat(coupon.purchase_qty)){
                                                                    qty_counter++;
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            //
                                        }

                                        if(coupon.product_discount == 'specific'){
                                            var product_counter = 0;
                                            // check if customer buys product under set category
                                            if(jQuery.inArray(parseInt(coupon.discount_product_id), arr_cart_products) !== -1){
                                                product_counter++;
                                            }

                                            if(product_counter > 0){
                                                var qty_counter = 0;

                                                var iteration = $('#iteration'+parseInt(coupon.discount_product_id)).val();
                                                var product_qty = $('#quantity'+iteration).val();
                                                // total amount purchase

                                                // total qty purchase
                                                // enable Use Coupon button if cart qty is greater than set coupon purchase qty 
                                                if(product_qty > parseFloat(coupon.purchase_qty)){
                                                    qty_counter++;
                                                }
                                            }
                                        }

                                        if(qty_counter > 0){
                                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_coupon_on_product('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                                        } else {
                                            var usebtn = '<button class="btn btn-success btn-sm disabled">Use Coupon</button>';
                                        }
                                    }
                                }
                            //

                            if(qty_counter > 0){
                                $('#collectibles').append(
                                    '<div class="coupon-item p-2 border rounded mb-1" id="coupondiv'+coupon.id+'">'+
                                        '<div class="row no-gutters">'+
                                            '<div class="col-12">'+
                                                '<input type="hidden" id="couponproducts'+coupon.id+'" value="'+coupon.purchase_product_id+'">'+
                                                '<input type="hidden" id="couponcategories'+coupon.id+'" value="'+coupon.purchase_product_cat_id+'">'+
                                                '<input type="hidden" id="couponbrands'+coupon.id+'" value="'+coupon.purchase_product_brand+'">'+

                                                '<input type="hidden" id="couponcombination'+coupon.id+'" value="'+coupon.combination+'">'+
                                                '<input type="hidden" id="remainingusage'+coupon.id+'" value="'+response.remaining[key]+'">'+
                                                '<input type="hidden" id="purchaseqty'+coupon.id+'" value="'+coupon.purchase_qty+'">'+
                                                '<input type="hidden" id="productdiscount'+coupon.id+'" value="'+coupon.product_discount+'">'+
                                                '<input type="hidden" id="discountproductid'+coupon.id+'" value="'+coupon.discount_product_id+'">'+
                                                '<input type="hidden" id="purchaseproductid'+coupon.id+'" value="'+coupon.purchase_product_id+'">'+
                                                '<input type="hidden" id="discountpercentage'+coupon.id+'" value="'+coupon.percentage+'">'+
                                                '<input type="hidden" id="discountamount'+coupon.id+'" value="'+coupon.amount+'">'+
                                                '<input type="hidden" id="couponname'+coupon.id+'" value="'+coupon.name+'">'+
                                                '<input type="hidden" id="couponcode'+coupon.id+'" value="'+coupon.coupon_code+'">'+
                                                '<input type="hidden" id="couponterms'+coupon.id+'" value="'+coupon.terms_and_conditions+'">'+
                                                '<input type="hidden" id="coupondesc'+coupon.id+'" value="'+coupon.description+'">'+
                                                '<input type="hidden" id="couponfreeproductid'+coupon.id+'" value="'+coupon.free_product_id+'">'+
                                                '<div class="coupon-item-name">'+
                                                    '<h5 class="m-0">'+coupon.name+' <span>'+validity+'</span></h5>'+
                                                '</div>'+
                                                '<div class="coupon-item-desc small mb-1">'+
                                                    '<span>'+coupon.description+'</span>'+
                                                '</div>'+
                                                '<div class="coupon-item-btns">'+
                                                    usebtn+'&nbsp;'+
                                                    '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="'+coupon.terms_and_conditions+'">Terms & Condition</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                );
                            } else {
                                $('#collectibles').append(
                                    '<div class="coupon-item p-2 border rounded mb-1 deactivate">'+
                                        '<div class="row no-gutters">'+
                                            '<div class="col-12">'+
                                                '<div class="coupon-item-name">'+
                                                    '<h5 class="m-0">'+coupon.name+' <span>'+validity+'</span></h5>'+
                                                '</div>'+
                                                '<div class="coupon-item-desc small mb-1">'+
                                                    '<span>'+coupon.description+'</span>'+
                                                '</div>'+
                                                '<div class="coupon-item-btns">'+
                                                    usebtn+'&nbsp;'+
                                                    '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="'+coupon.terms_and_conditions+'">Terms & Condition</button>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                );
                            }
                            
                        } else {
                            $('#collectibles').append(
                                '<div class="coupon-item p-2 border rounded mb-1 deactivate">'+
                                    '<div class="row no-gutters">'+
                                        '<div class="col-12">'+
                                            '<div class="coupon-item-name">'+
                                                '<h5 class="m-0">'+coupon.name+' <span>'+validity+'</span></h5>'+
                                            '</div>'+
                                            '<div class="coupon-item-desc small mb-1">'+
                                                '<span>'+coupon.description+'</span>'+
                                            '</div>'+
                                            '<div class="coupon-item-btns">'+
                                                '<button class="btn btn-success btn-sm disabled">Use Coupon</button>&nbsp;'+
                                                '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="'+coupon.terms_and_conditions+'">Terms & Condition</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'
                            );
                        }

                        $('[data-bs-toggle="popover"]').popover();
                        
                    });
                    $('#couponModal').modal('show');
                }
            });
        }


		$('#couponManualBtn').click(function(){
            var couponCode = $('#coupon_code').val();
            var grandtotal = parseFloat($('#grandTotal').val());

            $.ajax({
                data: {
                    "couponcode": couponCode,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('add-manual-coupon')}}",
                success: function(returnData) {

                    if(returnData['not_allowed']){
                        swal({
                            title: '',
                            text: "The coupon you entered is not valid.",         
                        });
                        return false;
                    }

                    if(returnData['not_exist']){
                        swal({
                            title: '',
                            text: "The coupon you entered is not valid.",         
                        });
                        return false; 
                    }

                    if(returnData['expired']){
                        swal({
                            title: '',
                            text: "Coupon is already expired.",         
                        });
                        return false;
                    }
                    if (returnData['success']) {
                        if(returnData.coupon_details['location'] != null){
                            swal({
                                title: '',
                                text: "Shipping fee coupons can only be used on checkout.",         
                            });
                            return false;
                        }

                        $('#manual-coupons').append(
                            '<input type="hidden" id="purchaseproductid'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['purchase_product_id']+'">'+
                            '<input type="hidden" id="discountpercentage'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['percentage']+'">'+
                            '<input type="hidden" id="discountamount'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['amount']+'">'+
                            '<input type="hidden" id="couponname'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['name']+'">'+
                            '<input type="hidden" id="couponcode'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['coupon_code']+'">'+
                            '<input type="hidden" id="couponterms'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['terms_and_conditions']+'">'+
                            '<input type="hidden" id="coupondesc'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['description']+'">'+
                            '<input type="hidden" id="couponfreeproductid'+returnData.coupon_details['id']+'" value="'+returnData.coupon_details['free_product_id']+'">'
                        );

                        if(returnData.coupon_details['amount_discount_type'] == 1){
                            if(returnData.coupon_details['free_product_id'] != null){
                                free_product_coupon(returnData.coupon_details['id']);
                            } else {
                                if(returnData.coupon_details['amount'] > 0){ 
                                    var amountdiscount = parseFloat(returnData.coupon_details['amount']);
                                }

                                if(returnData.coupon_details['percentage'] > 0){
                                    var percent  = parseFloat(returnData.coupon_details['percentage'])/100;
                                    var discount = parseFloat(grandtotal)*percent;

                                    var amountdiscount = parseFloat(discount);
                                }

                                var total = grandtotal-amountdiscount;
                                if(total.toFixed(2) < 1){
                                    swal({
                                        title: '',
                                        text: "The total amount is less than the coupon discount.",         
                                    });

                                    return false;
                                }

                                use_coupon_total_amount(returnData.coupon_details['id']);
                            }
                        } else {

                            if(returnData.coupon_details['amount'] > 0){ 
                                var amountdiscount = parseFloat(returnData.coupon_details['amount']);
                            }

                            if(returnData.coupon_details['percentage'] > 0){
                                var percent  = parseFloat(returnData.coupon_details['percentage'])/100;
                                var discount = parseFloat(grandtotal)*percent;

                                var amountdiscount = parseFloat(discount);
                            }

                            var total = grandtotal-amountdiscount;
                            if(total.toFixed(2) < 1){
                                swal({
                                    title: '',
                                    text: "The total amount is less than the coupon discount.",         
                                });

                                return false;
                            }

                            use_coupon_on_product(returnData.coupon_details['id']);
                        }
                    }  
                }
            });
        });

		function coupon_counter(cid){
            var limit = $('#coupon_limit').val();
            var counter = $('#coupon_counter').val();
            var solo_coupon_counter = $('#solo_coupon_counter').val();

            var combination = $('#couponcombination'+cid).val();

            if(parseInt(counter) < parseInt(limit)){

                if(combination == 0){
                    if(counter > 0){
                        swal({
                            title: '',
                            text: "Coupon cannot be used together with other coupons.",         
                        });
                        return false;
                    } else {
                        $('#solo_coupon_counter').val(1);
                        $('#coupon_counter').val(parseInt(counter)+1);
                        return true;
                    }
                } else {
                    if(solo_coupon_counter > 0){
                        swal({
                            title: '',
                            text: "Unable to use this coupon. A coupon that cannot be used together with other coupon is already been selected.",         
                        });
                        return false;
                    } else {
                        $('#coupon_counter').val(parseInt(counter)+1);
                        return true;
                    }
                }
            } else {
                swal({
                    title: '',
                    text: "Maximum of "+limit+" coupon(s) only.",         
                });
                return false;
            }
        }


	// use coupon on total amount   
        function use_coupon_total_amount(cid){

            var totalAmountDiscountCounter = $('#total_amount_discount_counter').val();
            var name  = $('#couponname'+cid).val();
            var desc = $('#coupondesc'+cid).val();
            var terms = $('#couponterms'+cid).val();
            var combination = $('#couponcombination'+cid).val();

            if(coupon_counter(cid)){
                if(parseInt(totalAmountDiscountCounter) == 1){
                    swal({
                        title: '',
                        text: "Only one (1) coupon with discount amount/percentage per transaction.",         
                    });

                    var counter = $('#coupon_counter').val();
                    $('#coupon_counter').val(parseInt(counter)-1);

                    return false;
                }

                $('#total_amount_discount_counter').val(1);
                // Modal Btns
                $('#couponBtn'+cid).prop('disabled',true);
                $('#btnCpnTxt'+cid).html('Applied');

                $('#couponList').append(
                    '<div id="couponDiv'+cid+'">'+
                        '<div class="coupon-item p-2 border rounded mb-1">'+
                            '<div class="row no-gutters">'+
                                '<div class="col-12">'+
                                    '<div class="coupon-item-name">'+
                                        '<h5 class="m-0">'+name+' <span></span></h5>'+
                                    '</div>'+
                                    '<div class="coupon-item-desc small mb-1">'+
                                        '<span>'+desc+'</span>'+
                                    '</div>'+
                                    '<div class="coupon-item-btns">'+
                                        '<input type="hidden" name="couponUsage[]" value="0">'+
                                        '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
                                        '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                        '<input type="hidden" name="coupon_productid[]" value="0">'+
                                        '<button type="button" class="btn btn-danger btn-sm couponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                        '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="'+terms+'">Terms & Condition</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );



                var grandTotal = $('#grandTotal').val();
                var amount= $('#discountamount'+cid).val();
                var percnt= $('#discountpercentage'+cid).val();

                if(amount > 0){ 
                    var amountdiscount = parseFloat(amount);
                }

                if(percnt > 0){
                    var percent  = parseFloat(percnt)/100;
                    var discount = parseFloat(grandTotal)*percent;

                    var amountdiscount = parseFloat(discount);
                }

                $('#discount_list').append('<input type="hidden" name="discount[]" id="discount'+cid+'" value="'+amountdiscount+'"/>');
                $('[data-bs-toggle="popover"]').popover();

                var coupon_discount = parseFloat($('#coupon_total_discount').val());

                var total_coupon_deduction = coupon_discount+amountdiscount;
                $('#coupon_total_discount').val(total_coupon_deduction.toFixed(2));
                $('#total_coupon_deduction').html('₱ '+addCommas(total_coupon_deduction.toFixed(2))); 
                $('#couponDiscountDiv').css('display','table-row');

                $('#total_amount_discount').val(amountdiscount);

                cart_total();
            }
        }

        $(document).on('click', '.couponRemove', function(){  
            var id = $(this).attr("id"); 

            var coupon_total_discount = parseFloat($('#coupon_total_discount').val());
            var total_amount_discount = $('#total_amount_discount').val();
            
            var updated_coupon_discount = coupon_total_discount-total_amount_discount;
            $('#coupon_total_discount').val(updated_coupon_discount.toFixed(2));
            $('#total_coupon_deduction').html('₱ '+ addCommas(updated_coupon_discount.toFixed(2))); 
            
            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var total_amount_counter = $('#total_amount_discount_counter').val();
            $('#total_amount_discount_counter').val(parseInt(total_amount_counter)-1);
            $('#total_amount_discount').val(0);

            var combination = $('#coupon_combination'+id).val();
            if(combination == 0){
                $('#solo_coupon_counter').val(0);
            }

            $('#couponDiv'+id+'').remove(); 
            cart_total();
        });
    // end use coupon on total amount

    // choose product
        function use_coupon_on_product(cid){
            var amount= $('#discountamount'+cid).val();
            var percnt= $('#discountpercentage'+cid).val();

            var name  = $('#couponname'+cid).val();
            var desc = $('#coupondesc'+cid).val();
            var terms = $('#couponterms'+cid).val();
            var pdiscount = $('#productdiscount'+cid).val();
            var discountproductid = parseFloat($('#discountproductid'+cid).val());
            var remaining = parseFloat($('#remainingusage'+cid).val());
            var purchaseqty = parseFloat($('#purchaseqty'+cid).val());

            var discount = 0;

            if(coupon_counter(cid)){
                if(pdiscount == 'specific'){
                    var iteration = $('#iteration'+discountproductid).val();
                    //var total_cart_reward = parseFloat($('#cart_product_reward'+iteration).val())

                    var pname = $('#product_name_'+iteration).val();
                    var productid = $('#pp'+iteration).val();
                    var combination = $('#couponcombination'+cid).val();

                    var sub_price = $('#sum_sub_price'+iteration).val();

                    if(amount > 0){
                        var productSubTotalDiscount = parseFloat(sub_price)-parseFloat(amount);
                        var discount = parseFloat(amount);
                    }

                    if(percnt > 0){
                        var percent = parseFloat(percnt)/100;
                        var discount =  parseFloat(sub_price)*parseFloat(percent);

                        //var productSubTotalDiscount = parseFloat(sub_price)-parseFloat(discount);
                        var productSubTotalDiscount = parseFloat(discount);
                    }

                    $('#couponList').append(
                        '<div id="couponDiv'+cid+'">'+
                            '<div class="coupon-item p-2 border rounded mb-1">'+
                                '<div class="row no-gutters">'+
                                    '<div class="col-12">'+
                                        '<div class="coupon-item-name">'+
                                            '<h5 class="m-0">'+name+' <span></span></h5>'+
                                        '</div>'+
                                        '<div class="coupon-item-desc small mb-1">'+
                                            '<span>'+desc+'</span><br>'+
                                            '<span class="text-success">Applied On : '+pname+'</span>'+
                                        '</div>'+
                                        '<div class="coupon-item-btns">'+
                                            '<input type="hidden" name="couponUsage[]" value="1">'+
                                            '<input type="hidden" id="coupon_discount'+cid+'" value="'+discount+'">'+
                                            '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
                                            '<input type="hidden" id="productid'+cid+'" value="'+iteration+'">'+
                                            '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                            '<input type="hidden" name="coupon_productid[]" value="'+productid+'">'+
                                            '<button type="button" class="btn btn-danger btn-sm productCouponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                            '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="'+terms+'">Terms & Condition</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    $('[data-bs-toggle="popover"]').popover();
                    $('#cart_product_reward'+iteration).val(1);
                }

                if(pdiscount == 'current'){

                    var products = $('#couponproducts'+cid).val();
                    var categories = $('#couponcategories'+cid).val();
                    var brands = $('#couponbrands'+cid).val();

                    if(products != ''){
                        var product_split = products.split('|');

                        var arr_purchase_products = [];
                        $.each(product_split, function(key, productID) {
                            if(productID != ''){
                                arr_purchase_products.push(parseInt(productID));    
                            }
                        });

                        var exist_counter = 0;
                        var arr_exist_product = [];
                        $("input[name='productid[]']").each(function() {
                            if(jQuery.inArray(parseInt($(this).val()), arr_purchase_products) !== -1){
                                arr_exist_product.push(parseInt($(this).val()));
                                exist_counter++
                            }
                        });

                        if(exist_counter > 0){
                            // get highest product purchase
                            var highest = -Infinity; 
                            var iteration;

                            $(".sum_sub_price").each(function() {
                                var id = $(this).data('id');
                                var productid = $(this).data('productid');

                                var x = $('#cart_product_reward'+id).val();
                                if(x == 0){
                                    if(jQuery.inArray(parseInt(productid), arr_exist_product) !== -1){
                                        highest = Math.max(highest, parseFloat(this.value));
                                    }
                                }
                            });
                                
                            $(".sum_sub_price").each(function() {
                                if(parseFloat(this.value) == parseFloat(highest.toFixed(2))){
                                    iteration = $(this).data('id');
                                }
                            });
                        }
                    }

                    if(categories != ''){
                        var category_split = categories.split('|');

                        var arr_purchase_categories = [];
                        $.each(category_split, function(key, brand) {
                            if(brand != ''){
                                arr_purchase_categories.push(brand);    
                            }
                        });

                        var exist_counter = 0;
                        var arr_exist_product = [];
                        $("input[name='productcatid[]']").each(function() {
                            if(jQuery.inArray($(this).val(), arr_purchase_categories) !== -1){
                                arr_exist_product.push(parseInt($(this).data('productid')));
                                exist_counter++
                            }
                        });

                        if(exist_counter > 0){
                            // get highest product purchase
                            var highest = -Infinity; 
                            var iteration;

                            $(".sum_sub_price").each(function() {
                                var id = $(this).data('id');
                                var productid = $(this).data('productid');

                                var x = $('#cart_product_reward'+id).val();
                                if(x == 0){
                                    if(jQuery.inArray(parseInt(productid), arr_exist_product) !== -1){
                                        highest = Math.max(highest, parseFloat(this.value));
                                    }
                                }
                            });
                                
                            $(".sum_sub_price").each(function() {
                                if(parseFloat(this.value) == parseFloat(highest.toFixed(2))){
                                    iteration = $(this).data('id');
                                }
                            });
                        }
                    }

                    if(brands != ''){
                        var brand_split = brands.split('|');

                        var arr_purchase_brands = [];
                        $.each(brand_split, function(key, brand) {
                            if(brand != ''){
                                arr_purchase_brands.push(brand);    
                            }
                        });

                        var exist_counter = 0;
                        var arr_exist_product = [];
                        $("input[name='productbrand[]']").each(function() {
                            if(jQuery.inArray($(this).val(), arr_purchase_brands) !== -1){
                                arr_exist_product.push(parseInt($(this).data('productid')));
                                exist_counter++
                            }
                        });

                        if(exist_counter > 0){
                            // get highest product purchase
                            var highest = -Infinity; 
                            var iteration;

                            $(".sum_sub_price").each(function() {
                                var id = $(this).data('id');
                                var productid = $(this).data('productid');

                                var x = $('#cart_product_reward'+id).val();
                                if(x == 0){
                                    if(jQuery.inArray(parseInt(productid), arr_exist_product) !== -1){
                                        highest = Math.max(highest, parseFloat(this.value));
                                    }
                                }
                            });
                                
                            $(".sum_sub_price").each(function() {
                                if(parseFloat(this.value) == parseFloat(highest.toFixed(2))){
                                    iteration = $(this).data('id');
                                }
                            });
                        }
                    }
                    
                    var price = parseFloat($('#price'+iteration).val());
                
                    var totalpurchaseqty = parseFloat($('#purchaseqty'+cid).val())+1;
                    var purchaseqty = parseFloat($('#purchaseqty'+cid).val());
                    var cartQty = parseFloat($('#quantity'+iteration).val());

                    if(cartQty % 2 == 0){
                        var totalProductCartQty = cartQty;
                    } else {
                        var totalProductCartQty = cartQty-1;
                    }

                    var totalDiscountedProduct = 0;
                    for (i = 1; i <= totalProductCartQty; i++) {
                        if(i == purchaseqty){
                            totalDiscountedProduct++;
                            var purchaseqty = parseInt(purchaseqty)+totalpurchaseqty;
                        }                                 
                    }

                    var i;
                    var totaldiscount = 0;

                    var pname = $('#product_name_'+iteration).val();
                    var productid = $('#pp'+iteration).val();
                    var combination = $('#couponcombination'+cid).val();

                    var counter = 0;
                    for (i = 1; i <= totalDiscountedProduct; i++) {
                        if(amount > 0){
                            var tdiscount = price-parseFloat(amount);
                        }

                        if(percnt > 0){
                            var percent = parseFloat(percnt)/100;
                            var discount =  price*parseFloat(percent);

                            //var tdiscount = price-parseFloat(discount);
                        } 

                        totaldiscount += discount;
                        discount = totaldiscount;
                        counter++;
                    }

                    $('#couponList').append(
                        '<div id="couponDiv'+cid+'">'+
                            '<div class="coupon-item p-2 border rounded mb-1">'+
                                '<div class="row no-gutters">'+
                                    '<div class="col-12">'+
                                        '<div class="coupon-item-name">'+
                                            '<h5 class="m-0">'+name+' <span></span></h5>'+
                                        '</div>'+
                                        '<div class="coupon-item-desc small mb-1">'+
                                            '<span>'+desc+'</span><br>'+
                                            '<span class="text-success">Applied On : '+pname+'</span>'+
                                        '</div>'+
                                        '<div class="coupon-item-btns">'+
                                            '<input type="hidden" name="couponUsage[]" value="'+counter+'">'+
                                            '<input type="hidden" id="coupon_discount'+cid+'" value="'+tdiscount+'">'+
                                            '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
                                            '<input type="hidden" id="productid'+cid+'" value="'+iteration+'">'+
                                            '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                            '<input type="hidden" name="coupon_productid[]" value="'+productid+'">'+
                                            '<button type="button" class="btn btn-danger btn-sm productCouponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                            '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="'+terms+'">Terms & Condition</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    $('#discount_list').append('<input type="hidden" name="discount[]" id="discount'+cid+'" value="'+discount+'"/>');
                    $('[data-bs-toggle="popover"]').popover();

                    var sub_price = $('#sum_sub_price'+iteration).val();
                    var productSubTotalDiscount = parseFloat(sub_price)-parseFloat(totaldiscount);
                }

                // Total Amount Coupon Discount 
                    var coupon_discount = parseFloat($('#coupon_total_discount').val());

                    var total_coupon_deduction = coupon_discount+discount;
                    $('#coupon_total_discount').val(total_coupon_deduction.toFixed(2));
                    $('#total_coupon_deduction').html('₱ '+addCommas(total_coupon_deduction.toFixed(2))); 
                    $('#couponDiscountDiv').css('display','block');
                //


                // Total Summary Computation
                    $('#cart_product_discount'+iteration).val(discount.toFixed(2));
                    $('#product_coupon_discount'+iteration).html('₱ '+addCommas(discount.toFixed(2)));
                    $('.couponDiscountSpan'+iteration).css('display','block');

                    $('#sum_sub_price'+iteration).val(productSubTotalDiscount.toFixed(2));

                    $('#product_total_price'+iteration).css('display','none');
                    $('#product_new_price'+iteration).css('display','block');
                    $('#product_new_price'+iteration).html('₱ '+addCommas(productSubTotalDiscount.toFixed(2))); 

                    cart_total();
                //

                $('#cart_product_reward'+iteration).val(1);
                $('#couponBtn'+cid).prop('disabled',true);
                $('#btnCpnTxt'+cid).html('Applied');
            }
        }

        $(document).on('click','.productCouponRemove', function(){
            var id = $(this).attr('id'); // coupon id
            var pid = $('#productid'+id).val(); // product iteration id

            var product_subtotal = parseFloat($('#sum_sub_price'+pid).val());
            var total_reward_on_product = $('#cart_product_reward'+pid).val();
            var discount = $('#coupon_discount'+id).val();

            var coupon_total_discount = parseFloat($('#coupon_total_discount').val());
            var coupon_product_discount = parseFloat($('#cart_product_discount'+pid).val());
            
            var updated_coupon_discount = coupon_total_discount-coupon_product_discount;
            $('#coupon_total_discount').val(updated_coupon_discount.toFixed(2));
            $('#total_coupon_deduction').html('₱ '+ addCommas(updated_coupon_discount.toFixed(2))); 

            $('#cart_product_reward'+pid).val(0);
            $('#cart_product_discount'+pid).val(0);

            $('#product_new_price'+pid).css('display','none');
            $('#product_total_price'+pid).css('display','block');
            $('.couponDiscountSpan'+pid).css('display','none');

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var combination = $('#coupon_combination'+id).val();
            if(combination == 0){
                $('#solo_coupon_counter').val(0);
            }

            $('#couponDiv'+id+'').remove(); 

            cart_total();
        });
    // end choose product


    	// coupon free products
        function free_product_coupon(cid){
            if(coupon_counter(cid)){
                var name  = $('#couponname'+cid).val();
                var terms = $('#couponterms'+cid).val();
                var desc = $('#coupondesc'+cid).val();
                var freeproductid = $('#couponfreeproductid'+cid).val();
                var combination = $('#couponcombination'+cid).val();

                $('#couponList').append(
                    '<div id="couponDiv'+cid+'">'+
                        '<div class="coupon-item p-2 border rounded mb-1">'+
                            '<div class="row no-gutters">'+
                                '<div class="col-12">'+
                                    '<div class="coupon-item-name">'+
                                        '<h5 class="m-0">'+name+' <span></span></h5>'+
                                    '</div>'+
                                    '<div class="coupon-item-desc small mb-1">'+
                                        '<span>'+desc+'</span>'+
                                    '</div>'+
                                    '<div class="coupon-item-btns">'+
                                        '<input type="hidden" name="couponUsage[]" value="0">'+
                                        '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
                                        '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                        '<input type="hidden" name="coupon_productid[]" value="0">'+
                                        '<input type="hidden" name="coupon_freeproductid[]" value="'+freeproductid+'">'+
                                        '<button type="button" class="btn btn-danger btn-sm cRmvFreeProduct" id="'+cid+'">Remove</button>&nbsp;'+
                                        '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+terms+'">Terms & Conditions</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );


                $('#discount_list').append('<input type="hidden" name="discount[]" id="discount'+cid+'" value="0"/>');
                $('[data-bs-toggle="popover"]').popover();

                $('#couponBtn'+cid).prop('disabled',true);
                $('#btnCpnTxt'+cid).html('Applied');
            }
        }

        $(document).on('click', '.cRmvFreeProduct', function(){  
            var id = $(this).attr("id");  

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var combination = $('#coupon_combination'+id).val();
            if(combination == 0){
                $('#solo_coupon_counter').val(0);
            }

            $('#couponDiv'+id+'').remove();   
        });
    	//
	</script>
@endsection