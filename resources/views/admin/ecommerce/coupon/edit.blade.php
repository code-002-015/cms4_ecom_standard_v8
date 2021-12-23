@extends('admin.layouts.app')

@section('pagecss')
	<link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
	<link href="{{ asset('lib/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
	<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
	<style>
		.select2 {width:100% !important;}

		.select2-container--default .select2-selection--multiple .select2-selection__choice{
			position: relative;
		    margin-top: 4px;
		    margin-right: 4px;
		    padding: 3px 10px 3px 20px;
		    border-color: transparent;
		    border-radius: 1px;
		    background-color: #0168fa;
		    color: #fff;
		    font-size: 13px;
		    line-height: 1.45;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
			color: #fff;
		    opacity: .5;
		    font-size: 14px;
		    font-weight: 400;
		    display: inline-block;
		    position: absolute;
		    top: 4px;
		    left: 7px;
		    line-height: 1.2;
		}
	</style>
@endsection

@section('content')
<div class="container pd-x-0">
	<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
					<li class="breadcrumb-item" aria-current="page"><a href="{{ route('coupons.index') }}">Coupons</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit Coupon</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Coupon</h4>
		</div>
	</div>

	<form method="post" action="{{ route('coupons.update',$coupon->id) }}" id="couponForm" autocomplete="off">
		@csrf
		@method('PUT')
		<div class="row row-sm">
			<div class="col-lg-6">
				<div class="form-group">
					<label class="d-block">Name *</label>
					<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$coupon->name) }}">
					@error('name')
						<span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				<div class="form-group">
					<label class="d-block">Description *</label>
					<textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description',$coupon->description) }}</textarea>
					@error('description')
						<span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				<div class="form-group">
					<label class="d-block">Terms and Conditions *</label>
					<textarea name="terms_and_conditions" rows="3" class="form-control @error('terms_and_conditions') is-invalid @enderror">{{ old('terms_and_conditions',$coupon->terms_and_conditions) }}</textarea>
					@error('terms_and_conditions')
						<span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>
				<div class="form-group">
					<label class="d-block">Distribution Type</label>
					<div class="row" style="padding-bottom: 10px;">
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input @if(old('coupon_activation') == 'auto' || $coupon->activation_type == 'auto') checked @endif type="radio" id="coupon-activate-auto" name="coupon_activation" class="custom-control-input" value="auto"  onclick="ShowHideDiv()">
								<label class="custom-control-label" for="coupon-activate-auto">Automatically Enabled</label>
							</div>
							<small style="font-style: italic;">Coupon is automatically enabled after customer completes an activity.</small>
						</div>
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input @if(old('coupon_activation') == 'manual' || $coupon->activation_type == 'manual') checked @endif type="radio" id="coupon-activate-manual" name="coupon_activation" class="custom-control-input" value="manual" onclick="ShowHideDiv()">
								<label class="custom-control-label" for="coupon-activate-manual">Manual</label>
							</div>
							<small style="font-style: italic;">Customer inputs a code to redeem coupon reward.</small>
						</div>
					</div>
					<div class="mb-3" id="coupon-code" style="display: @if(old('coupon_activation') == 'manual' || $coupon->activation_type == 'manual') block @else none @endif;">
						<label class="d-block">Coupon Code</label>
						<input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code',$coupon->coupon_code) }}">
						@error('code')
							<span class="text-danger">{{ $message }}</span>
                    	@enderror
					</div>
				</div>
				<div class="form-group">
					<label class="d-block">Customer Scope</label>
					<div class="row" style="padding-bottom: 10px;">
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input type="radio" id="coupon-scope-all" name="coupon_scope" class="custom-control-input" value="all" onclick="ShowHideDiv()" @if($coupon->customer_scope == 'all') checked @endif>
								<label class="custom-control-label" for="coupon-scope-all">All</label>
							</div>
							<small style="font-style: italic;">Coupon will be applicable to all customers who completed an activity.</small>
						</div>
						<div class="col-6">
							<div class="custom-control custom-radio">
								<input type="radio" id="coupon-scope-specific" name="coupon_scope" class="custom-control-input" value="specific" onclick="ShowHideDiv()" @if($coupon->customer_scope == 'specific') checked @endif>
								<label class="custom-control-label" for="coupon-scope-specific">Specific</label>
							</div>
							<small style="font-style: italic;">Only the specific customer will be able to use and claim the coupon reward.</small>
						</div>
					</div>
				</div>
				@php
					$arr_customer_ids = [];
					$customer_ids = explode('|',$coupon->scope_customer_id);
					foreach($customer_ids as $id){
						array_push($arr_customer_ids,$id);
					}
				@endphp
				<div class="form-group">
					<div class="mb-3 reward-option" id="customer-optn" style="display:@if($coupon->customer_scope == 'specific') block @else none @endif">
						<label class="d-block">Customer Name *</label>
						<select class="form-control select2" name="customer[]" multiple="multiple">
							<option label="Choose one"></option>
							@foreach($customers as $customer)
								<option @if(in_array($customer->email, $arr_customer_ids)) selected @endif value="{{$customer->email}}">{{ $customer->name }}</option>
							@endforeach
						</select>
						@error('customer')
							<span class="text-danger">{{ $message }}</span>
                    	@enderror
					</div>
				</div>
				<div class="form-group">
					<label class="d-block">Reward</label>
					<select class="custom-select @error('reward') is-invalid @enderror" id="reward-optn" name="reward">
						<option @if(isset($coupon->location)) selected @endif value="free-shipping-optn">Free Shipping</option>
						<option @if(isset($coupon->amount) )selected @endif value="discount-amount-optn">Discount Amount</option>
						<option @if(isset($coupon->percentage)) selected @endif value="discount-percentage-optn">Discount Percentage</option>
						<option @if(isset($coupon->free_product_id)) selected @endif value="free-product-optn">Free Product/Gift</option>
					</select>
					@error('reward')
						<span class="text-danger">{{ $message }}</span>
                    @enderror
				</div>

				@php
					$arr_loc = [];
					$locs = explode('|',$coupon->location);
					foreach($locs as $l){
						array_push($arr_loc,$l);
					}
				@endphp
				<div class="form-group">
					<div class="mb-3 reward-option" id="free-shipping-optn" style="display:@if(isset($coupon->location)) block @else none @endif">
						<label class="d-block">Location</label>
						<select class="form-control select2" name="location[]" multiple="multiple" style="min-height: 32px;">
							<option label="Select Area"></option>
							<option value="all" @if(in_array('all',$arr_loc)) selected @endif>All Area</option>
							@foreach($locations as $location)
								<option @if(in_array($location->name,$arr_loc)) selected @endif value="{{$location->name}}">{{ $location->name }}</option>
							@endforeach
						</select>
						@error('location')
							<span class="text-danger">{{ $message }}</span>
                    	@enderror

						<br><br>
						<label class="d-block">Discount Type</label>
						<div class="row">
							<div class="col-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="coupon-discount-type-partial" name="discount_type" class="custom-control-input" value="partial" onchange="sf_discount_type()" @if($coupon->location_discount_type == 'partial') checked @endif>
									<label class="custom-control-label" for="coupon-discount-type-partial">Partial</label>
								</div>
							</div>
							<div class="col-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="coupon-discount-type-full" name="discount_type" class="custom-control-input" value="full" onchange="sf_discount_type()" @if($coupon->location_discount_type == 'full') checked @endif>
									<label class="custom-control-label" for="coupon-discount-type-full">Full</label>
								</div>
							</div>
						</div>

						<label class="mg-t-10" id="discount_amount_label" style="display: @if($coupon->location_discount_type == 'full') none @else block @endif;">Shipping Fee Discount Amount</label>
						<input type="number" name="shipping_fee_discount_amount" class="form-control @error('shipping_fee_discount_amount') is-invalid @enderror" id="discount_amount_input" value="{{ $coupon->location_discount_amount }}" style="display: @if($coupon->location_discount_type == 'full') none @else block @endif;">
						@error('shipping_fee_discount_amount')
							<span class="text-danger">{{ $message }}</span>
                    	@enderror

					</div>

					<div class="mb-3 reward-option" id="discount-amount-optn" style="display:@if(isset($coupon->amount)) block @else none @endif">
						<label class="d-block">Discount Amount</label>
						<input name="discount_amount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" value="{{ $coupon->amount }}" placeholder="Php">
						@error('discount_amount')
							<span class="text-danger">{{ $message }}</span>
                    	@enderror
					</div>

					<div class="mb-3 reward-option" id="discount-percentage-optn" style="display:@if(isset($coupon->percentage)) block @else none @endif">
						<label class="d-block">Discount Percentage</label>
						<input name="discount_percentage" type="number" class="form-control @error('discount_percentage') is-invalid @enderror" value="{{ $coupon->percentage }}" placeholder="%">
						@error('discount_percentage')
							<span class="text-danger">{{ $message }}</span>
                    	@enderror
					</div>

					<div id="div_product_amount" style="display: @if(isset($coupon->amount) || isset($coupon->percentage)) block @else none @endif;">
                		<div class="row" style="padding-bottom: 10px;margin-top: 20px;">
							<div class="col-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="discount-total-amount" name="amount_discount" class="custom-control-input" value="1" onclick="product_discount_amount(1)" @if($coupon->amount_discount_type == 1) checked @endif>
									<label class="custom-control-label" for="discount-total-amount">Total Amount</label>
								</div>
							</div>
							<div class="col-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="discount-product-price" name="amount_discount" class="custom-control-input" value="2" onclick="product_discount_amount(2)" @if($coupon->amount_discount_type == 2) checked @endif>
									<label class="custom-control-label" for="discount-product-price">Product Price</label>
								</div>
							</div>
						</div>

						<div class="row" style="padding-bottom: 10px;margin-top: 20px;display: @if($coupon->amount_discount_type == 2) flex @else none @endif;" id="discount_selection">
							<div class="col-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="same-product" name="product_discount" class="custom-control-input" value="current" onchange="productdiscount('current')" @if($coupon->product_discount == 'current') checked @endif>
									<label class="custom-control-label" for="same-product">Same Product</label>
								</div>
							</div>
							<div class="col-6">
								<div class="custom-control custom-radio">
									<input type="radio" id="specific-product" name="product_discount" class="custom-control-input" value="specific" onchange="productdiscount('specific')" @if($coupon->product_discount == 'specific') checked @endif>
									<label class="custom-control-label" for="specific-product">Specific Product</label>
								</div>
							</div>
						</div>

						<div style="display: @if($coupon->product_discount == 'specific') block @else none @endif;" id="discount_productid">
							<select class="form-control select2" name="discount_productid">
								<option label="Choose Product"></option>
								@foreach($products as $product)
									<option @if($coupon->discount_product_id == $product->id) selected @endif value="{{$product->id}}">{{ $product->name }}</option>
								@endforeach
							</select>
						</div>
                	</div>

					<div class="mb-3 reward-option" id="free-product-optn" style="display:@if(isset($coupon->free_product_id)) block @else none @endif">
						<label class="d-block">Free Product</label>
						<select class="form-control select2" name="free_product_id" style="min-height: 32px;">
							<option label="Choose one"></option>
							@foreach($free_products as $product)
								<option @if($coupon->free_product_id == $product->id) selected @endif value="{{$product->id}}">{{ $product->name }}</option>
							@endforeach
						</select>
						@error('free_product_id')
							<span class="text-danger">{{ $message }}</span>
                    	@enderror
					</div>
					<hr>
				</div>

				<br>
				<h4 class="mg-b-0 tx-spacing--1">Coupon Settings</h4>
				<hr>

				<div class="form-group">	
					<label class="d-block">Time 
						&nbsp;&nbsp;<span style="font-style: italic;">Set the date/time validity of the coupon.</span>
					</label>
					<input type="checkbox" class="custom-control-input" id="coupon-time" name="coupon_setting[]" value="time" checked style="display: none;">
				</div>

				<div class="form-row border rounded p-3 pt-4 mb-4" id="coupon-time-option" style="display:flex;">
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-date-time" name="coupon_time[]" class="custom-control-input" onclick="ShowHideDiv()" value="datetime" @if(is_array(old('coupon_time')) && in_array('datetime', old('coupon_time')) || isset($coupon->start_date)) checked @endif>
							<label class="custom-control-label" for="coupon-date-time">Date and Time</label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="custom-control custom-radio">
							<input type="radio" id="coupon-custom" name="coupon_time[]" class="custom-control-input" onclick="ShowHideDiv()" value="custom" @if(is_array(old('coupon_time')) && in_array('custom', old('coupon_time')) || isset($coupon->event_name)) checked @endif>
							<label class="custom-control-label" for="coupon-custom">Custom</label>
						</div>
					</div>

					<div class="col-12" id="coupon-date-time-form" style="display:@if(is_array(old('coupon_time')) && in_array('datetime', old('coupon_time')) || isset($coupon->start_date)) block @else none @endif;">
						<div class="row mt-3">
							<div class="col-6">
								<label class="d-block">Start Date *</label>
								<input name="startdate" type="text" id="dateFrom" class="form-control" placeholder="From" autocomplete="off" value="{{ old('startdate',$coupon->start_date) }}">
								<small id="spanDatefrom" style="display: none;" class="text-danger"></small>
							</div>
							<div class="col-6">
								<label class="d-block">End Date</label>
								<input name="enddate" type="text" id="dateTo" class="form-control" placeholder="To" autocomplete="off" value="{{ old('enddate',$coupon->end_date) }}">
							</div>
						</div>

						<div class="row mt-3">
							<div class="col-6">
								<label class="d-block">Start Time</label>
								<input name="starttime" type="time" class="form-control" autocomplete="off" value="{{ $coupon->start_time }}">
							</div>
							<div class="col-6">
								<label class="d-block">End Time</label>
								<input name="endtime" type="time" class="form-control" autocomplete="off" value="{{ $coupon->end_time }}">
							</div>
						</div>
					</div>

					<div class="col-12" id="coupon-custom-form" style="display:@if(is_array(old('coupon_time')) && in_array('custom', old('coupon_time')) || isset($coupon->event_name)) block @else none @endif;">
						<div class="row mt-3">
							<div class="col-md-6">
								<label class="d-block">Event Name *</label>
								<input name="eventname" id="eventname" type="text" class="form-control" autocomplete="off" value="{{ old('eventname',$coupon->event_name) }}">
								<small class="text-danger" style="display: none;" id="spanEventName"></small>
							</div>
							<div class="col-md-6">
								<label class="d-block">Date *</label>
								<input name="eventdate" id="eventdate" type="text" class="form-control singlecalendar" placeholder="Choose date" autocomplete="off" value="{{ old('eventdate',$coupon->event_date) }}">
								<small class="text-danger" style="display: none;" id="spanEventDate"></small>
							</div>
							<div class="col-12 mt-3">
								<div class="custom-control custom-switch">
									<input name="repeat_annually" type="checkbox" {{old("repeat_annually") == "ON" || $coupon->repeat_annually == 1 ? "checked":"" }} class="custom-control-input" id="customSwitch1" >
									<label class="custom-control-label" for="customSwitch1">Repeat Annually</label>
								</div>
							</div>
						</div>
					</div>
				</div>






				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="coupon-purchase" onclick="myFunction()" name="coupon_setting[]" value="purchase" @if(isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand) || isset($coupon->purchase_amount) || isset($coupon->purchase_qty)) checked @endif>
						<label class="custom-control-label" for="coupon-purchase">Purchase 
							&nbsp;&nbsp;<span style="font-style: italic;">Coupon is received after the purchase conditions have been met.</span>
						</label>
					</div>
				</div>

				<div class="form-row border rounded p-3 mb-4" id="coupon-purchase-option" style="display:@if(isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand) || isset($coupon->purchase_amount) || isset($coupon->purchase_qty)) flex @else none @endif;">
					<div class="col-md-3">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" id="coupon-product" name="purchase_product" class="custom-control-input" onclick="purchase_products()"  @if(isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand)) checked @endif >
							<label class="custom-control-label" for="coupon-product">Product</label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" id="coupon-amount" name="purchase_total_amount" class="custom-control-input" onclick="total_amount_purchase()" @if(isset($coupon->purchase_amount)) checked @endif>
							<label class="custom-control-label" for="coupon-amount">Total Amount</label>
						</div>
					</div>
					<div class="col-md-3">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" id="coupon-quantity" name="purchase_total_qty" class="custom-control-input" onclick="total_amount_purchase()" @if(isset($coupon->purchase_qty)) checked @endif>
							<label class="custom-control-label" for="coupon-quantity">Total Quantity</label>
						</div>
					</div>

					<div class="col-12 mt-3" id="coupon-product-form" style="display:@if(isset($coupon->purchase_product_id) || isset($coupon->purchase_product_cat_id) || isset($coupon->purchase_product_brand)) block @else none @endif;">
						<small class="text-danger" style="display: none;" id="spanProductOpt"></small>
						<div class="form-group">
							<label class="d-block">Product Name</label>
							@php
								$arr_products = [];
								$arr_categories = [];
								$arr_brands = [];

								$coupon_products = explode('|',$coupon->purchase_product_id);
								$coupon_categories = explode('|',$coupon->purchase_product_cat_id);
								$coupon_brands = explode('|',$coupon->purchase_product_brand);

								foreach($coupon_products as $cprod){
									array_push($arr_products,$cprod);
								}

								foreach($coupon_categories as $ccat){
									array_push($arr_categories,$ccat);
								}

								foreach($coupon_brands as $cbrand){
									array_push($arr_brands,$cbrand);
								}
							@endphp
							<select class="form-control select2" multiple="multiple" name="product_name[]" id="product_opt">
								<option label="Choose one"></option>
								@foreach($products as $product)
									<option @if(in_array($product->id,$arr_products)) selected @endif value="{{$product->id}}">{{ $product->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label class="d-block">Category</label>
							<select class="form-control select2" multiple="multiple" name="product_category[]" id="category_opt">
								<option label="Choose one"></option>
								@foreach($categories as $category)
									<option @if(in_array($category->id,$arr_categories)) selected @endif value="{{$category->id}}">{{ $category->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label class="d-block">Brand</label>
							<select class="form-control select2" multiple="multiple" name="product_brand[]" id="brand_opt">
								<option label="Choose one"></option>
								@foreach($brands as $brand)
									<option @if(in_array($brand->brand,$arr_brands)) selected @endif value="{{$brand->brand}}">{{$brand->brand}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-12 mt-3" id="coupon-amount-form" style="display:@if(isset($coupon->purchase_amount) || isset($coupon->purchase_qty)) block @else none @endif">
						<div class="row">
							<div class="col-12" id="total-amount-div" style="display:@if(isset($coupon->purchase_amount)) block @else none @endif;">
								<label class="d-block">Total Amount *</label>
							</div>
							<div class="col-md-6" id="total-amount-input" style="display:@if(isset($coupon->purchase_amount)) block @else none @endif;">
								<input name="purchase_amount" id="purchase_amount" type="number" min="1" class="form-control" value="{{ $coupon->purchase_amount }}">
								<small id="spanPurchaseAmount" style="display: none;" class="text-danger"></small>
							</div>
							<div class="col-md-6" id="total-amount-select" style="display:@if(isset($coupon->purchase_amount)) block @else none @endif;">
								<select class="custom-select" name="amount_opt" id="amount_opt">
									<option value="">Choose One</option>
									<option @if($coupon->purchase_amount_type == 'min') selected @endif value="min">Minimum</option>
									<option @if($coupon->purchase_amount_type == 'max') selected @endif value="max">Maximum</option>
								</select>
								<small id="spanAmountOpt" style="display: none;" class="text-danger"></small>
							</div>

							<!-- Quantity -->
							<div class="col-12" id="total-quantity-div" style="padding-top: 10px;display:@if(isset($coupon->purchase_qty)) block @else none @endif;">
								<label class="d-block">Total Quantity *</label>
							</div>
							<div class="col-md-6" id="total-quantity-input" style="display:@if(isset($coupon->purchase_qty)) block @else none @endif;">
								<input name="purchase_qty" id="purchase_qty" type="number" min="1" class="form-control" value="{{ $coupon->purchase_qty }}">
								<small id="spanPurchaseQty" style="display: none;" class="text-danger"></small>
							</div>
							<div class="col-md-6" id="total-quantity-select" style="display:@if(isset($coupon->purchase_qty)) block @else none @endif;">
								<select class="custom-select" name="qty_opt" id="qty_opt">
									<option value="min">Minimum</option>
								</select>
								<small id="spanQtyOpt" style="display: none;" class="text-danger"></small>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">	
					<label class="d-block">Rules 
						&nbsp;&nbsp;<span style="font-style: italic;">Set specific rules on the coupon.</span>
					</label>
				</div>

				<div class="form-row border rounded p-3">
					<div class="col-12">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="coupon-customer-limit" name="customer_limit" onclick="myFunction()" @if($coupon->customer_scope == 'specific') disabled @else  @if($coupon->customer_limit <> 100000) checked @endif @endif>
							<label class="custom-control-label" for="coupon-customer-limit">Customer Limit &nbsp;&nbsp;<span style="font-style: italic;">Maximum number of customers who can use the coupon.</span></label>
						</div>

						<div class="mt-3" id="coupon-customer-limit-form" style="display:@if($coupon->customer_scope == 'specific') none @else @if($coupon->customer_limit <> 100000) block @else none @endif @endif;">
							<div class="input-group border rounded">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="coupon_customer_limit_qty">
										<span class="fa fa-minus"></span>
									</button>
								</span>
								@php
									if($coupon->customer_scope == 'all'){
										if($coupon->customer_limit == 100000){
											$customerLimit = 1;
										} else {
											$customerLimit = $coupon->customer_limit;
										}
									} else {
										$customerLimit = 1; 
									}
								@endphp
								<input type="text" name="coupon_customer_limit_qty" class="form-control input-number border border-top-0 border-bottom-0" value="{{ old('coupon_customer_limit_qty',$customerLimit)}}" min="1" max="100000">
								<span class="input-group-btn">
									<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="coupon_customer_limit_qty">
										<span class="fa fa-plus"></span>
									</button>
								</span>
							</div>
							<hr>
						</div>
					</div>

					<div class="col-12 mt-3">
						<div class="custom-control custom-checkbox">
							<input {{ (old("combination") == "ON" || $coupon->combination == 1 ? "checked":"") }} type="checkbox" class="custom-control-input" id="coupon-combination" name="combination">
							<label class="custom-control-label" for="coupon-combination">Coupon Combination &nbsp;&nbsp;<span style="font-style: italic;">Can be used together with other coupons.</span></label>
						</div>
					</div>
				</div>

				<hr>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label class="d-block">Status</label>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="enableSwitch1" name="status" {{ (old("status") == "ON" || $coupon->status == "ACTIVE" ? "checked":"") }}>
						<label class="custom-control-label" for="enableSwitch1" id="label_status">{{ucfirst(strtolower($coupon->status))}}</label>
					</div>
				</div>
			</div>

			<div class="col-lg-12 mg-t-30">
				<button class="btn btn-primary btn-sm btn-uppercase" type="button" id="btnSubmit">Update</button>
				<a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
			</div>
		</div>
	</form>
	<!-- row -->
</div>

<div class="modal effect-scale" id="prompt-no-selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.no_selected_title')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="no_selected_title"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
	<script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
	<script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
	<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('lib/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
@endsection


@section('customjs')
<script>
	$('#coupon-scope-specific').click(function(){
		$('#coupon-customer-limit').prop('checked',false);
		$('#coupon-customer-limit-form').hide();
		$('#coupon-customer-limit').attr('disabled',true);
	});

	$('#coupon-scope-all').click(function(){
		$('#coupon-customer-limit').attr('disabled',false);
	});

	function productdiscount(x){
		if(x == 'specific'){
			$('#discount_productid').css('display','block');
		} else {
			$('#discount_productid').css('display','none');
		}
	}
	function product_discount_amount(x){
		if(x == 2){
			$('#discount_selection').css('display','flex');
		} else {
			$('#discount_selection').css('display','none');
		}
	}

	$('#reward-optn').change(function(){
		$('.reward-option').hide();
		$('#' + $(this).val()).show();

		if($(this).val() == 'discount-amount-optn' || $(this).val() == 'discount-percentage-optn'){
			$('#div_product_amount').show();
		} else {
			$('#div_product_amount').hide();
		}
	});

	function sf_discount_type(){
		var option = $('input[name="discount_type"]:checked').val();

		if(option == 'full'){
			$('#discount_amount_label').css('display','none');
			$('#discount_amount_input').css('display','none');
		} else {
			$('#discount_amount_label').css('display','block');
			$('#discount_amount_input').css('display','block');
		}
	}

	function total_amount_purchase(){
		if($('#coupon-amount').is(':checked') || $('#coupon-quantity').is(':checked')){
			$('#coupon-amount-form').css('display','block');
		} else {
			$('#coupon-amount-form').css('display','none');
		}

		if($('#coupon-amount').is(':checked')){
			$('#total-amount-div').css('display','block');
			$('#total-amount-input').css('display','block');
			$('#total-amount-select').css('display','block');
		} else {
			$('#total-amount-div').css('display','none');
			$('#total-amount-input').css('display','none');
			$('#total-amount-select').css('display','none');
		}

		if($('#coupon-quantity').is(':checked')){
			$('#total-quantity-div').css('display','block');
			$('#total-quantity-input').css('display','block');
			$('#total-quantity-select').css('display','block');
		} else {
			$('#total-quantity-div').css('display','none');
			$('#total-quantity-input').css('display','none');
			$('#total-quantity-select').css('display','none');
		}
	}

	function purchase_products(){
		if($('#coupon-product').is(':checked')){
			$('#coupon-product-form').css('display','block');
		} else {
			$('#coupon-product-form').css('display','none');
		}
		
	}

	$('#product_opt').change(function(){
		var value = $(this).val();

		if(value != ''){
			$('#category_opt').attr("disabled", true);
			$('#brand_opt').attr("disabled", true);
		} else {
			$('#category_opt').removeAttr("disabled");
			$('#brand_opt').removeAttr("disabled");
		}
	});

	$('#category_opt').change(function(){
		var selected = '';
		$('#category_opt :selected').each(function(){
		    selected += $(this).val()+'|';
		});

		$.ajax({
            type: "GET",
            url: "{{ route('display.product-brands') }}",
            data: { 
                'categories' : selected,
            },
            success: function(response) {
            	$('#brand_opt').empty();

            	if(response['success']){
            		$.each(response.brands, function(key, value) {
	            		$('#brand_opt').append(
	            			'<option value="'+value.brand+'">'+value.brand+'</option>'
	            		);
            		});
            	}
            }
        });

		var value = parseInt($(this).val());
		if(value != ''){
			$('#product_opt').attr("disabled", true);
		} else {
			$('#product_opt').removeAttr("disabled");
		}
	});

	$('#brand_opt').change(function(){
		var value = $(this).val();

		if(value != ''){
			$('#product_opt').attr("disabled", true);
		} else {
			$('#product_opt').removeAttr("disabled");
		}
	});

	$('#btnSubmit').click(function(){

		if(!$("input[name='coupon_setting[]']:checked").val()) {  
				$('#no_selected_title').html('Please select at least one (1) coupon setting.');      
                $('#prompt-no-selected').modal('show');
                return false;
            } else {
            	var rs;
            	$('input[name="coupon_setting[]"]:checked').each(function(){

				   	if(this.value == 'time') {
				   		var selectedOption = $('input[name="coupon_time[]"]:checked').val();

				   		if(selectedOption == 'datetime'){
				   			var startdate = $('#dateFrom').val();
					   		if(startdate.length === 0){
					   			$('#dateFrom').addClass('is-invalid');
					   			$('#spanDatefrom').css('display','block');
					   			$('#spanDatefrom').html('Start Date field is required.');
					   			rs = false;
            					return false;
					   		}
				   		}

				   		if(selectedOption == 'custom'){
				   			var eventname = $('#eventname').val();
				   			var eventdate = $('#eventdate').val();

				   			if(eventname.length === 0){
				   				$('#eventname').addClass('is-invalid');
					   			$('#spanEventName').css('display','block');
					   			$('#spanEventName').html('Event name field is required.');
					   			rs = false;
            					return false;
				   			}

				   			if(eventdate.length === 0){
				   				$('#eventdate').addClass('is-invalid');
					   			$('#spanEventDate').css('display','block');
					   			$('#spanEventDate').html('Event date field is required.');
					   			rs = false;
            					return false;
				   			}
				   		}

				   		rs = true;	
				   	}

				   	if(this.value == 'purchase') {
				   		if($('#coupon-product').is(':checked') || $('#coupon-amount').is(':checked') || $('#coupon-quantity').is(':checked')) {

				   			$('#coupon-purchase-option').removeClass('is-invalid');
				   			var selectedOption = $('input[name="coupon_purchase[]"]:checked').val();

				   			if($('#coupon-product').is(':checked')){
				   				var product = $('#product_opt').val();
				   				var category = $('#category_opt').val();
				   				var brand = $('#brand_opt').val();

				   				if(product.length === 0 && category.length === 0 && brand.length === 0){
				   					$('.select2-container').css('border','1px solid red');
				   					$('.select2-container').css('border-radius','0.25rem');
				   					$('#spanProductOpt').css('display','block');
				   					$('#spanProductOpt').html('Please select at least one(1) option.');
				   					rs = false;
	            					return false;
				   				}

				   				rs = true;
				   			}

				   			if($('#coupon-amount').is(':checked')){
				   				var amount = $('#purchase_amount').val();
						   		var amounttype = $('#amount_opt').val();

						   		if(amount.length === 0){
						   			$('#purchase_amount').addClass('is-invalid');
						   			$('#spanPurchaseAmount').css('display','block');
						   			$('#spanPurchaseAmount').html('Amount field is required.');
						   			rs = false;
	            					return false;
						   		}

						   		if(amounttype.length === 0){
						   			$('#amount_opt').addClass('is-invalid');
						   			$('#spanAmountOpt').css('display','block');
						   			$('#spanAmountOpt').html('Please select one(1) option.');
						   			rs = false;
	            					return false;
						   		}

						   		rs = true;
				   			}

				   			if($('#coupon-quantity').is(':checked')){
				   				var qty = $('#purchase_qty').val();
						   		var qtytype = $('#qty_opt').val();

						   		if(qty.length === 0){
						   			$('#purchase_qty').addClass('is-invalid');
						   			$('#spanPurchaseQty').css('display','block');
						   			$('#spanPurchaseQty').html('Quantity field is required.');
						   			rs = false;
	            					return false;
						   		}

						   		if(qtytype.length === 0){
						   			$('#qty_opt').addClass('is-invalid');
						   			$('#spanQtyOpt').css('display','block');
						   			$('#spanQtyOpt').html('Please select one(1) option.');
						   			rs = false;
						   			return false;
						   		}
				   			}

				   			rs = true;
				   		} else {
				   			$('#coupon-purchase-option').addClass('is-invalid');
				   			$('#no_selected_title').html('Please select at least one (1) purchase option.');      
                			$('#prompt-no-selected').modal('show');
                			rs = false;
	            			return false;
				   		}
				   	}
				});
				
				if(rs == true){
					$('#couponForm').submit();
				}
            }
	});

	$("#enableSwitch1").change(function() {
        if(this.checked) {
            $('#label_status').html('Active');
        }
        else{
            $('#label_status').html('Inactive');
        }
    });

	$('.datetime').clockpicker();

	$('.singlecalendar').datepicker({
		dateFormat: 'yy-mm-dd'
	});

	var dateToday = new Date(); 
	$('#dateFrom').datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: dateToday,
	});
	$('#dateTo').datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: dateToday,
	});

	$('.select2').select2({
		placeholder: 'Choose Options'
	});

	function myFunction() {
		var checkCouponTime = document.getElementById("coupon-time");
		var fieldCouponOption = document.getElementById("coupon-time-option");
		if (checkCouponTime.checked == true){
			fieldCouponOption.style.display = "flex";
		} else {
			fieldCouponOption.style.display = "none";
		};

		var couponPurchase = document.getElementById("coupon-purchase");
		var fieldCouponOption = document.getElementById("coupon-purchase-option");
		if (couponPurchase.checked == true){
			fieldCouponOption.style.display = "flex";
		} else {
			fieldCouponOption.style.display = "none";
		};

		var couponCustomerLimit = document.getElementById("coupon-customer-limit");
		var fieldCustomerLimitOption = document.getElementById("coupon-customer-limit-form");
		if (couponCustomerLimit.checked == true){
			fieldCustomerLimitOption.style.display = "block";
		} else {
			fieldCustomerLimitOption.style.display = "none";
		};
	};

	function ShowHideDiv() {
		var couponDateTime = document.getElementById("coupon-date-time");
		var couponDateTimeForm = document.getElementById("coupon-date-time-form");
		couponDateTimeForm.style.display = couponDateTime.checked ? "block" : "none";

		var couponCustom = document.getElementById("coupon-custom");
		var couponCustomForm = document.getElementById("coupon-custom-form");
		couponCustomForm.style.display = couponCustom.checked ? "block" : "none";


		var scopeSpecific = document.getElementById("coupon-scope-specific");
		var customerOption = document.getElementById("customer-optn");
		customerOption.style.display = scopeSpecific.checked ? "block" : "none";

		var scopeAll= document.getElementById("coupon-scope-all");
		var customerOptionAll = document.getElementById("customer-optn");
		customerOptionAll.style.display = scopeAll.checked ? "none" : "block";

		var activateManual= document.getElementById("coupon-activate-manual");
		var couponCodeManual = document.getElementById("coupon-code");
		couponCodeManual.style.display = activateManual.checked ? "none" : "block";

		var autoManual= document.getElementById("coupon-activate-auto");
		var couponCodeAuto = document.getElementById("coupon-code");
		couponCodeAuto.style.display = autoManual.checked ? "none" : "block";
	};

// Points Earned start --------------------->
    $('.btn-number').click(function(e){
      	e.preventDefault();

      	fieldName = $(this).attr('data-field');
      	type      = $(this).attr('data-type');
      	var input = $("input[name='"+fieldName+"']");
      	var currentVal = parseInt(input.val());
      	if (!isNaN(currentVal)) {
        	if(type == 'minus') {

          		if(currentVal > input.attr('min')) {
            		input.val(currentVal - 1).change();
          		} 
          		if(parseInt(input.val()) == input.attr('min')) {
            		$(this).attr('disabled', true);
          		}
        	} else if(type == 'plus') {

          		if(currentVal < input.attr('max')) {
            		input.val(currentVal + 1).change();
          		}
          		if(parseInt(input.val()) == input.attr('max')) {
            		$(this).attr('disabled', true);
          		}

        	}
      	} else {
        	input.val(0);
      	}
    });

    $('.input-number').focusin(function(){
    	$(this).data('oldValue', $(this).val());
    });

    $('.input-number').change(function() {

      	minValue =  parseInt($(this).attr('min'));
      	maxValue =  parseInt($(this).attr('max'));
      	valueCurrent = parseInt($(this).val());

      	name = $(this).attr('name');
      	if(valueCurrent >= minValue) {
        	$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
      	} else {
        	alert('Sorry, the minimum value was reached');
        	$(this).val($(this).data('oldValue'));
      	}
      	if(valueCurrent <= maxValue) {
        	$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    	} else {
        	alert('Sorry, the maximum value was reached');
        	$(this).val($(this).data('oldValue'));
    	}
    });

    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
       	// Allow: Ctrl+A
      	(e.keyCode == 65 && e.ctrlKey === true) || 
       	// Allow: home, end, left, right
      	(e.keyCode >= 35 && e.keyCode <= 39)) {
         	// let it happen, don't do anything
         	return;
    	}
    	// Ensure that it is a number and stop the keypress
    	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      		e.preventDefault();
    	}
    });
// Points Earned end --------------------->

$(function() {
	$('.selectpicker').selectpicker();
});
</script>
@endsection