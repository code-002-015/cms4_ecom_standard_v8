@extends('theme.ecommerce.main')

@section('content')
<div class="content-wrap">
	<div class="container clearfix">

		<div class="row col-mb-30 gutter-50 mb-4">
			<div class="col-md-6">
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						Have a coupon? <a href="login-register.html">Click here to enter your code</a>
					</div>
				</div>
			</div>
		</div>

		<form name="shipping-form" class="row mb-0" method="post" action="{{ route('cart.temp_sales') }}">
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

					<div class="col-12 form-group">
						<label for="billing-form-address">Address:</label>
						<input type="text" id="billing-form-address" name="delivery_address" value="{{ auth()->user()->address }}" class="sm-form-control" />
					</div>

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
					<div class="col-md-6 form-group">
						<label for="shipping-form-name">Name:</label>
						<input type="text" id="shipping-form-name" name="shipping-form-name" value="" class="sm-form-control" />
					</div>

					<div class="col-md-6 form-group">
						<label for="shipping-form-lname">Last Name:</label>
						<input type="text" id="shipping-form-lname" name="shipping-form-lname" value="" class="sm-form-control" />
					</div>

					<div class="w-100"></div>

					<div class="col-12 form-group">
						<label for="shipping-form-companyname">Company Name:</label>
						<input type="text" id="shipping-form-companyname" name="shipping-form-companyname" value="" class="sm-form-control" />
					</div>

					<div class="col-12 form-group">
						<label for="shipping-form-address">Address:</label>
						<input type="text" id="shipping-form-address" name="shipping-form-address" value="" class="sm-form-control" />
					</div>

					<div class="col-12 form-group">
						<input type="text" id="shipping-form-address2" name="shipping-form-adress" value="" class="sm-form-control" />
					</div>

					<div class="col-12 form-group">
						<label for="shipping-form-city">City / Town</label>
						<input type="text" id="shipping-form-city" name="shipping-form-city" value="" class="sm-form-control" />
					</div>

					<div class="col-12 form-group">
						<label for="shipping-form-message">Notes <small>*</small></label>
						<textarea class="sm-form-control" id="shipping-form-message" name="shipping-form-message" rows="6" cols="30"></textarea>
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
								@php $subtotal = 0; $grandtotal = 0; @endphp

								@foreach($orders as $order)

								@php
									$subtotal += $order->price*$order->qty;
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
										<input type="hidden" name="total_amount" value="{{$subtotal}}">
										<input type="hidden" name="delivery_fee" value="0">
										<span class="amount color lead"><strong>₱{{ number_format($subtotal,2) }}</strong></span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="accordion clearfix">
						<div class="accordion-header">
							<div class="accordion-icon">
								<i class="accordion-closed icon-line-minus"></i>
								<i class="accordion-open icon-line-check"></i>
							</div>
							<div class="accordion-title">
								Direct Bank Transfer
							</div>
						</div>
						<div class="accordion-content clearfix">Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</div>

						<div class="accordion-header">
							<div class="accordion-icon">
								<i class="accordion-closed icon-line-minus"></i>
								<i class="accordion-open icon-line-check"></i>
							</div>
							<div class="accordion-title">
								Cheque Payment
							</div>
						</div>
						<div class="accordion-content clearfix">Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum.</div>

						<div class="accordion-header">
							<div class="accordion-icon">
								<i class="accordion-closed icon-line-minus"></i>
								<i class="accordion-open icon-line-check"></i>
							</div>
							<div class="accordion-title">
								Paypal
							</div>
						</div>
						<div class="accordion-content clearfix">Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus. Aenean lacinia bibendum nulla sed consectetur.</div>
					</div>
					<button type="submit" class="button button-3d float-end">Place Order</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('pagejs')

@endsection