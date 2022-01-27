@extends('theme.ecommerce.main')

@section('pagecss')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="content-wrap">
	<div class="container clearfix">

		<div class="row col-mb-30 gutter-50 mb-4">
			<div class="col-md-6">
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						Have a coupon? <a href="#" onclick="myCoupons()">Click here to enter your code</a>
					</div>
				</div>
			</div>
		</div>

		<form name="shipping-form" class="row mb-0" method="post" action="{{ route('cart.temp_sales') }}" id="chk_form">
			@csrf
			<div class="row col-mb-50 gutter-50">
				<div class="col-lg-6">
					<h3>Billing Address</h3>

					<div class="col-md-12 form-group">
						<label for="billing-form-name">Name:</label>
						<input type="text" id="billing-form-name" name="fname" value="{{ auth()->user()->firstname }}" class="sm-form-control" />
					</div>

					<div class="col-md-12 form-group">
						<label for="billing-form-lname">Last Name:</label>
						<input type="text" id="billing-form-lname" name="lname" value="{{ auth()->user()->lastname }}" class="sm-form-control" />
					</div>

					<div class="w-100"></div>

					<div class="col-md-12 form-group">
						<label for="billing-form-email">Email Address:</label>
						<input type="email" id="billing-form-email" name="email" value="{{ auth()->user()->email }}" class="sm-form-control" />
					</div>

					<div class="col-md-12 form-group">
						<label for="billing-form-mobile">Mobile:</label>
						<input type="text" id="billing-form-mobile" name="mobile" value="{{ auth()->user()->mobile }}" class="sm-form-control" />
					</div>
				</div>

				<div class="col-lg-6">
					<h3>Shipping Address</h3>
					<div class="accordion clearfix">
						<div class="accordion-header" onclick="shipping_type('d2d');">
							<div class="accordion-icon">
								<i class="accordion-closed icon-line-minus"></i>
								<i class="accordion-open icon-line-check"></i>
							</div>
							<div class="accordion-title">
								Door-to-door Delivery
							</div>
						</div>
						<div class="accordion-content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

						<!-- <div class="accordion-header" onclick="shipping_type('stp');">
							<div class="accordion-icon">
								<i class="accordion-closed icon-line-minus"></i>
								<i class="accordion-open icon-line-check"></i>
							</div>
							<div class="accordion-title">
								Store Pickup
							</div>
						</div>
						<div class="accordion-content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div> -->

						<input type="hidden" name="shipping_type" id="shipping_type" value="d2d">
					</div>

					<div class="w-100"></div>

					<div class="col-12 form-group">
						<label for="shipping-form-address">Address:</label>
						<input type="text" name="address_street" id="address_street" value="" class="sm-form-control" />
					</div>

					<div class="col-12 form-group">
						<label for="shipping-form-city">Municipality</label>
						<select class="form-control" name="location" id="location">
							<option selected value="">Choose Municipality</option>
							@foreach($locations as $loc)
								<option value="{{$loc->name}}|{{$loc->rate}}">{{$loc->name}}</option>
							@endforeach
						</select>
					</div>

					<div class="col-12 form-group">
						<label for="shipping-form-message">Instruction <small>*</small></label>
						<textarea class="sm-form-control" name="instruction" rows="6" cols="30"></textarea>
					</div>				
				</div>

				<div class="w-100"></div>

				<div class="col-lg-6">
					<h4>Your Orders</h4>
					<div class="table-responsive">
						<table class="table cart">
							<thead>
								<tr>
									<th class="cart-product-thumbnail">&nbsp;</th>
									<th class="cart-product-name">Product</th>
									<th class="cart-product-quantity">Quantity</th>
									<th class="cart-product-price">Unit Price</th>
									<th class="cart-product-subtotal">Total</th>
								</tr>
							</thead>
							<tbody>
								@php $subtotal = 0; $totalqty = 0; $grandtotal = 0; @endphp

								@foreach($orders as $order)

								@php
									$subtotal += $order->price*$order->qty;
									$totalqty += $order->qty;
								@endphp
								<tr class="cart_item">
									<td class="cart-product-thumbnail">
										<a href="#"><img width="64" height="64" src="{{ asset('storage/products/'.$order->product->photoPrimary) }}" alt="{{ $order->product->name }}"></a>
									</td>

									<td class="cart-product-name">
										<a href="#">{{ $order->product->name }}</a>
									</td>

									<td class="cart-product-quantity">
										<div class="quantity clearfix">
											{{ $order->qty }}
										</div>
									</td>

									<td class="cart-product-subtotal">
										<span class="amount">₱{{ number_format($order->price,2) }}</span>
									</td>

									<td class="cart-product-subtotal">
										<span class="amount">₱{{ number_format($order->price*$order->qty,2) }}</span>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div id="couponList">
						<div id="couponDiv">
							@php $counter = 0; $soloCouponCounter = 0; @endphp
							@foreach($coupons as $cpn)
							@php 
	                            $counter++; 

	                            if($cpn->details->combination == 0){
	                                $soloCouponCounter++;
	                            }
	                        @endphp
	                        <div class="coupon-item p-2 border rounded mb-1">
	                            <div class="row no-gutters">
	                                <div class="col-12">
	                                    <div class="coupon-item-name">
	                                        <h5 class="m-0">{{ $cpn->details->name }}<span></span></h5>
	                                    </div>
	                                    <div class="coupon-item-desc small mb-1">
	                                        <span>{{ $cpn->details->description }}</span>
	                                    </div>
	                                    <div class="coupon-item-btns">
	                                        <input type="hidden" name="couponUsage[]" value="0">
	                                        <input type="hidden" id="coupon_combination" value="{{$cpn->details->combination}}">
	                                        <input type="hidden" name="couponid[]" value="{{$cpn->coupon_id}}">
	                                        <input type="hidden" name="coupon_productid[]" value="{{$cpn->product_id}}">
	                                        <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="{{ $cpn->details->terms_and_conditions }}">Terms & Condition</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        @endforeach

	                        <input type="hidden" name="coupon_counter" id="coupon_counter" value="{{$counter}}">
	                    </div>
					</div>
				</div>

				<div class="col-lg-6">
					<h4>Cart Totals</h4>

					<div class="table-responsive">
						<table class="table cart">
							<tbody>
								<tr class="cart_item">
									<td class="border-top-0 cart-product-name">
										<strong>Cart Subtotal</strong>
									</td>

									<td class="border-top-0 cart-product-name">
										<span class="amount">₱{{ number_format($subtotal,2) }}</span>
									</td>
								</tr>
								<tr class="cart_item">
									<td class="border-top-0 cart-product-name">
										<strong>Coupon Discount</strong>
									</td>

									<td class="border-top-0 cart-product-name">
										<input type="hidden" id="coupon_total_discount" name="coupon_total_discount" value="{{$cart->coupon_discount}}">
										<span class="amount">₱{{ number_format($cart->coupon_discount,2) }}</span>
									</td>
								</tr>

								<tr class="cart_item">
									<td class="cart-product-name">
										<strong>Shipping Fee</strong>
									</td>

									<td class="cart-product-name">
                                        <input type="hidden" id="delivery_fee" name="delivery_fee" value="0">
										<span class="amount" id="shipping_fee">₱0.00</span>
									</td>
								</tr>

								<tr class="cart_item" id="tr_sf_discount" style="display:none;">
									<td class="cart-product-name">
										<strong>Shipping Fee Discount</strong>
									</td>

									<td class="cart-product-name">
										<input type="hidden" name="sf_discount_amount" id="sf_discount_amount" value="0">
                                        <input type="hidden" id="sf_discount_coupon" value="0">
										<span class="amount" id="shipping_fee_disocunt">₱0.00</span>
									</td>
								</tr>

								<tr class="cart_item">
									<td class="cart-product-name">
										<strong>Total</strong>
									</td>

									<td class="cart-product-name">
										<input type="hidden" name="total_amount" id="total_amount" value="{{$subtotal}}">
										<span class="amount color lead"><strong><p id="span_total_amount">₱{{ number_format($subtotal-$cart->coupon_discount,2) }}</p></strong></span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<button type="button" class="button button-3d float-end" onclick="place_order();">Place Order</button>
				</div>
			</div>
		</form>
	</div>
</div>

<input type="hidden" id="totalAmountWithoutCoupon" value="{{number_format($subtotal,2,'.','')}}">
<input type="hidden" id="totalQty" value="{{$totalqty}}">

<input type="hidden" id="coupon_limit" value="{{ Setting::info()->coupon_limit }}">
<input type="hidden" id="solo_coupon_counter" value="{{$soloCouponCounter}}">

@include('theme.ecommerce.pages.modal')
@endsection

@section('pagejs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
	function shipping_type(stype){
		$('#shipping_type').val(stype);
	}


	$('#location').change(function(){
		var stype = $('#shipping_type').val();
		var val   = ($(this).val()).split('|');

		var dfee  = parseFloat(val[1])
           
        if(stype == 'stp'){
        	$('#shipping_fee').html('₱0.00');
			$('#delivery_fee').val(0);
        } else {
        	$('#shipping_fee').html('₱'+addCommas(dfee.toFixed(2)));
			$('#delivery_fee').val(dfee);
        }

        compute_total();
    });

	function place_order() {   

	    var stype = $('#shipping_type').val(); 

	    if(stype == 'd2d'){

	        if($('#location').val() == ""){
	            swal({
	                title: '',
	                text: 'Please select your municipality.',
	                icon: 'warning'
	            });              
	            return false;
	        }
	    }

	    if($('#address_street').val()==''){
	        swal({
	            title: '',
	            text: 'Please enter Address.',
	            icon: 'warning'
	        });
	        return false;
	    }

	    $('#chk_form').submit();
	}




	$(document).ready(function(){
		$('[data-bs-toggle="popover"]').popover();
	});

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

    function myCoupons(){
    	if($('#location').val() == ""){
            swal({
                title: '',
                text: 'Please select your municipality.',
                icon: 'warning'
            });              
            return false;
        }

        var totalAmount = $('#totalAmountWithoutCoupon').val();
        var totalQty = $('#totalQty').val();

        $.ajax({
            type: "GET",
            url: "{{ route('display.collectibles') }}",
            data: {
                'total_amount' : totalAmount,
                'total_qty' : totalQty,
                'page_name' : 'checkout',
            },
            success: function( response ) {
                $('#collectibles').empty();

                var arr_selected_coupons = [];
                $("input[name='couponid[]']").each(function() {
                    arr_selected_coupons.push(parseInt($(this).val()));
                });

                $.each(response.coupons, function(key, coupon) {
                    if(coupon.end_date == null){
                        var validity = '';  
                    } else {
                        if(coupon.end_time == null){
                            var validity = ' Valid Till '+coupon.end_date;
                        } else {
                            var validity = ' Valid Till '+coupon.end_date+' '+coupon.end_time;
                        }
                    }

                    if(jQuery.inArray(coupon.id, response.availability) !== -1){

                        if(jQuery.inArray(coupon.id, arr_selected_coupons) !== -1){
                            var usebtn = '<button class="btn btn-success btn-sm" disabled>Applied</button>';
                        } else {
                            var usebtn = '<button class="btn btn-success btn-sm" id="couponBtn'+coupon.id+'" onclick="use_sf_coupon('+coupon.id+')"><span id="btnCpnTxt'+coupon.id+'">Use Coupon</span></button>';
                        }

                        $('#collectibles').append(
                            '<div class="coupon-item p-2 border rounded mb-1" id="coupondiv'+coupon.id+'">'+
                                '<div class="row no-gutters">'+
                                    '<div class="col-12">'+
                                        '<input type="hidden" id="couponcombination'+coupon.id+'" value="'+coupon.combination+'">'+
                                        '<input type="hidden" id="sflocation'+coupon.id+'" value="'+coupon.location+'">'+
                                        '<input type="hidden" id="sfdiscountamount'+coupon.id+'" value="'+coupon.location_discount_amount+'">'+
                                        '<input type="hidden" id="sfdiscounttype'+coupon.id+'" value="'+coupon.location_discount_type+'">'+
                                        '<input type="hidden" id="discountpercentage'+coupon.id+'" value="'+coupon.percentage+'">'+
                                        '<input type="hidden" id="discountamount'+coupon.id+'" value="'+coupon.amount+'">'+
                                        '<input type="hidden" id="couponname'+coupon.id+'" value="'+coupon.name+'">'+
                                        '<input type="hidden" id="couponcode'+coupon.id+'" value="'+coupon.coupon_code+'">'+
                                        '<input type="hidden" id="couponterms'+coupon.id+'" value="'+coupon.terms_and_conditions+'">'+
                                        '<input type="hidden" id="coupondesc'+coupon.id+'" value="'+coupon.description+'">'+
                                        '<div class="coupon-item-name">'+
                                            '<h5 class="m-0">'+coupon.name+' <br><span>'+validity+'</span></h5>'+
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


    // shipping fee coupon rewards
        function use_sf_coupon(cid){
            // check total use shipping fee coupons
            var sfcoupon = parseFloat($('#sf_discount_coupon').val());

            if(sfcoupon == 1){
                swal({
                    title: '',
                    text: "Only one (1) coupon for shipping fee discount.",         
                });
                return false;
            }

            // check if selected coupon applicable on selected delivery location
            var option = $('input[name="shipping_type"]:checked').val();
            if(option == 'storepickup'){
                swal({
                    title: '',
                    text: "Shipping fee coupon discount is only applicable on Delivery option!",         
                });
                return false;
            }
            
            if(coupon_counter(cid)){
                var selectedLocation = $('#location').val();
                var loc = selectedLocation.split('|');

                var couponLocation = $('#sflocation'+cid).val();
                var cLocation = couponLocation.split('|');

                var arr_coupon_location = [];
                $.each(cLocation, function(key, value) {
                    arr_coupon_location.push(value);
                });

                if(jQuery.inArray(loc[0], arr_coupon_location) !== -1 || jQuery.inArray('all', arr_coupon_location) !== -1){

                    var name  = $('#couponname'+cid).val();
                    var terms = $('#couponterms'+cid).val();
                    var desc = $('#coupondesc'+cid).val();
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
                                            '<input type="hidden" id="coupon_combination'+cid+'" value="'+combination+'">'+
                                            '<input type="hidden" name="couponid[]" value="'+cid+'">'+
                                            '<input type="hidden" name="coupon_productid[]" value="0">'+
                                            '<button type="button" class="btn btn-danger btn-sm sfCouponRemove" id="'+cid+'">Remove</button>&nbsp;'+
                                            '<button type="button" class="btn btn-info btn-sm" data-toggle="popover" title="Terms & Condition" data-content="'+terms+'">Terms & Conditions</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    $('#sf_discount_coupon').val(1);
                    var sf_type = $('#sfdiscounttype'+cid).val();
                    var sf_discount = parseFloat($('#sfdiscountamount'+cid).val());

                    if(sf_type == 'full'){
                        dfee = parseFloat($('#delivery_fee').val());

                        $('#sf_discount_amount').val(dfee);

                        $('#tr_sf_discount').css('display','table-row');
                        $('#shipping_fee_disocunt').html('₱'+addCommas(dfee.toFixed(2)));
                    }

                    if(sf_type == 'partial'){
                        $('#sf_discount_amount').val(sf_discount.toFixed(2));

                        $('#tr_sf_discount').css('display','table-row');
                        $('#shipping_fee_disocunt').html('₱'+addCommas(sf_discount.toFixed(2)));
                    }

                    $('#couponBtn'+cid).prop('disabled',true);
                    $('#btnCpnTxt'+cid).html('Applied');

                    compute_total();
                } else {
                    swal({
                        title: '',
                        text: "Selected delivery location is not in the coupon location.",         
                    });
                } 
            }
        }

        $(document).on('click', '.sfCouponRemove', function(){  
            var id = $(this).attr("id");  

            $('#tr_sf_discount').css('display','none');
            
            $('#sf_discount_amount').val(0);
            var totalsfdiscoutcounter = $('#sf_discount_coupon').val();
            $('#sf_discount_coupon').val(parseInt(totalsfdiscoutcounter)-1);

            var counter = $('#coupon_counter').val();
            $('#coupon_counter').val(parseInt(counter)-1);

            var combination = $('#coupon_combination'+id).val();
            if(combination == 0){
                $('#solo_coupon_counter').val(0);
            }

            $('#couponDiv'+id+'').remove();

            compute_total();
        });


        function compute_total(){

            var delivery_fee = parseFloat($('#delivery_fee').val());
            var delivery_discount = parseFloat($('#sf_discount_amount').val());


            var orderAmount = parseFloat($('#totalAmountWithoutCoupon').val());
            var couponDiscount = parseFloat($('#coupon_total_discount').val());

            var orderTotal  = orderAmount-couponDiscount;
            var deliveryFee = delivery_fee-delivery_discount;

            var grandTotal = parseFloat(orderTotal)+parseFloat(deliveryFee);

            $('#span_total_amount').html(addCommas(parseFloat(grandTotal).toFixed(2)));
            $('#total_amount').val(grandTotal.toFixed(2));
        }
    //
</script>

@endsection