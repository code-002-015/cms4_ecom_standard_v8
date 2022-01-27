@extends('theme.ecommerce.main')

@section('pagecss')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="content-wrap">
	<div class="container clearfix">

		<div class="row gutter-40 col-mb-80">
			<div class="postcontent col-lg-9 order-lg-last">
				<div id="shop" class="shop row grid-container gutter-20" data-layout="fitRows">
					@forelse($products as $product)  
						<div class="product col-md-4 col-sm-6 col-12">
							<div class="grid-inner">
								<div class="product-image">
									@foreach($product->photos as $photo)
										<a href="#"><img src="{{ asset('storage/products/'.$photo->path) }}" alt=""></a>
									@endforeach

									{{--@if($product->Maxpurchase > 0)--}}
										<div class="bg-overlay">
											<div class="bg-overlay-content align-items-end justify-content-between" data-hover-animate="fadeIn" data-hover-speed="400">
												<a href="javascript:void(0)" onclick="add_to_cart('{{$product->id}}',1);" class="btn btn-dark me-2"><i class="icon-shopping-cart"></i></a>
											</div>
											<div class="bg-overlay-bg bg-transparent"></div>
										</div>
									{{--@else--}}
										{{--<div class="sale-flash badge bg-secondary p-2">Out of Stock</div>--}}
									{{--@endif--}}
								</div>
								<div class="product-desc">
									<div class="product-title"><h3><a href="#">{{ $product->name }}</a></h3></div>
									<div class="product-price">
										@if(Product::onsale_checker($product->id) > 0)
										 	<del>₱{{ number_format($product->price,2) }}</del>
										 	<ins>₱{{ number_format($product->discountedprice,2) }}</ins>
                                        @else
                                            <ins>₱{{ number_format($product->discountedprice,2) }}</ins>
                                        @endif
									</div>
								</div>
							</div>
						</div>
					@empty

					@endforelse
				</div>
			</div>

			<div class="sidebar col-lg-3">
				<div class="sidebar-widgets-wrap">

					<div class="widget widget_links clearfix">

						<h4>Categories</h4>
						@if ($categories->count())
                            <ul>
                                @foreach ($categories as $category)
                                    <li><a href="#">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('pagejs')
<script>
	function add_to_cart(product,qty){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            data: {
                "product_id": product, 
                "qty": qty,
                "_token": "{{ csrf_token() }}",
            },
            type: "post",
            url: "{{route('cart.add')}}",
            success: function(returnData) {
                $("#loading-overlay").hide();
                if (returnData['success']) {

                    $('.top-cart-number').html(returnData['totalItems']);

                    $.notify("Product Added to your cart",{ 
                        position:"bottom right", 
                       	className: "success" 
                    });

                } else {
                    swal({
                        toast: true,
                        position: 'center',
                        title: "Warning!",
                        text: "We have insufficient inventory for this item.",
                        type: "warning",
                        showCancelButton: true,
                        timerProgressBar: true, 
                        closeOnCancel: false
                        
                    });
                }
            }
        });
    }
</script>
@endsection