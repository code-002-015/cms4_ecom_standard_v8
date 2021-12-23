@extends('admin.layouts.app')

@section('pagetitle')
    Order Manager
@endsection

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>
        .row-selected {
            background-color: #92b7da !important;
        }
    </style>
@endsection

@section('content')

        <!-- container start-->
            <div class="container pd-x-0">
                <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                                <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('sales-transaction.index')}}">Sales Transaction</a></li>
                            </ol>
                        </nav>
                        <h4 class="mg-b-0 tx-spacing--1"> Sales Transaction Summary</h4>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary btn-sm tx-semibold" onclick="window.print();"><i data-feather="printer"></i> Print</button>
                    </div>
                </div>

                <div class="row row-sm">

                    <div class="col-sm-6 col-lg-8">
                        <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Customer Details</label>
                        <p class="mg-b-3 tx-semibold">{{$sales->customer_name}}</p>
                        <p class="mg-b-3">{{$sales->customer_address}}</p>
                        <p class="mg-b-3">Tel No: {{$sales->customer_contact_number}}</p>
                        <p class="mg-b-3">Email: {{$sales->customer_details->email}}</p>
                        <p class="mg-b-3">Instruction: {{$sales->other_instruction}}</p>
                    </div>
                    <!-- col -->
                    <div class="col-sm-6 col-lg-4">
                        <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Order Details</label>
                        <ul class="list-unstyled lh-7">
                            <li class="d-flex justify-content-between">
                                <span>Order Date</span>
                                <span>{{ date('F d, Y', strtotime($sales->created_at))}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Order Number</span>
                                <span>{{$sales->order_number}}</span>
                            </li>                            
                            <li class="d-flex justify-content-between">
                                <span>Order Status</span>
                                <span class="tx-success tx-semibold tx-uppercase">{{$status}}</span>
                            </li>
                            <hr>
                            <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Payment Details</label>
                            @php $num = 1; @endphp
                            @forelse($salesPayments as $payment)

                            <li class="d-flex justify-content-between">
                                <span>@if($num == 1) {{$num++}}st @elseif($num == 2) {{$num++}}nd @else {{$num++}}rd @endif Payment Type </span>
                                <span>{{$payment->payment_type}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Payment Status</span>
                                <span class="tx-success tx-semibold tx-uppercase">{{$payment->status}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Payment Date</span>
                                <span>{{ date('F d, Y', strtotime($payment->payment_date))}}</span>
                            </li>
                            <li class="d-flex justify-content-between mg-b-15">
                                <span>Receipt Number</span>
                                <span>{{$payment->receipt_number}}</span>
                            </li>
                            @empty
                            @endforelse
                            <li class="d-flex justify-content-between">
                                <span>Response Code</span>
                                <span>{{$sales->response_code}}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- col -->

                    <div class="table-responsive mg-t-20">
                        <table class="table table-invoice bd-b">
                            <thead>
                            <tr>
                                <th class="wd-10p">Product Code</th>
                                <th class="wd-30p">Product Name</th>
                                <th class="tx-center">Quantity</th>
                                <th class="tx-right">Price</th>
                                <th class="tx-right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $gross = 0; $discount = 0; $subtotal = 0; @endphp
                            @forelse($salesDetails as $details)
                            
                            @php
                                $discount = \App\EcommerceModel\CouponSale::total_product_discount($sales->id,$details->product_id,$details->qty,$details->price);
                                $product_subtotal = $details->price*$details->qty;

                                $subtotal += $product_subtotal;
                            @endphp
                            <tr>
                                <td class="tx-nowrap">{{$details->product->code}}</td>
                                <td class="tx-nowrap">{{$details->product_name}}</td>
                                <td class="tx-center">{{number_format($details->qty, 0)}}</td>
                                <td class="tx-right">{{number_format($details->price, 2)}}</td>
                                <td class="tx-right">{{number_format($product_subtotal, 2)}}</td>
                               
                            </tr>
                            @empty
                                <tr>
                                    <td class="tx-center " colspan="6">No transaction found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-6 order-2 order-sm-0 mg-t-40 mg-sm-t-0">
                        <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Shipping Details</label>
                        <ul class="list-unstyled lh-7 pd-r-10">
                            <li class="d-flex justify-content-between">
                                <span>Delivery Type</span>
                                <span>{{($sales->delivery_type == 'storepickup') ? 'Store Pickup' : 'Door to Door'}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Delivery Address</span>
                                <span>{{$sales->customer_delivery_adress}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Delivery Status</span>
                                <span class="tx-primary tx-semibold tx-uppercase">{{$sales->delivery_status}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Delivery Tracking Number</span>
                                <span>{{$sales->delivery_tracking_number}}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Delivery Fee</span>
                                <span>{{number_format($sales->delivery_fee_amount, 2)}}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- col -->
                    <div class="offset-lg-2 col-lg-4 order-1 order-sm-0 mg-b-30">
                        <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Payment Breakdown</label>
                        <ul class="list-unstyled lh-7 pd-r-10">
                            @php $num = 1; @endphp
                            @forelse($salesPayments as $payment)
                            <li class="d-flex justify-content-between">
                                <span>@if($num == 1) {{$num++}}st @elseif($num == 2) {{$num++}}nd @else {{$num++}}rd @endif Payment</span>
                                <span>{{number_format($payment->amount, 2)}}</span>
                            </li>
                            @empty
                            @endforelse

                            @php
                                $delivery_discount = \App\EcommerceModel\CouponSale::total_discount_delivery($sales->id);
                                $net_amount = ($subtotal-$sales->discount_amount)+($sales->delivery_fee_amount-$delivery_discount);
                            @endphp
                            <hr>
                            <li class="d-flex justify-content-between">
                                <span>Sub Total</span>
                                <span>{{number_format($subtotal, 2)}}</span>
                            </li>

                            @if($sales->discount_amount > 0)
                            <li class="d-flex justify-content-between">
                                <span>Coupon Discount</span>
                                <span>{{number_format($sales->discount_amount, 2)}}</span>
                            </li>
                            @endif

                            <li class="d-flex justify-content-between">
                                <span>Delivery Fee</span>
                                <span>{{number_format($sales->delivery_fee_amount, 2)}}</span>
                            </li>

                            @if($delivery_discount > 0)
                            <li class="d-flex justify-content-between">
                                <span>Delivery Discount</span>
                                <span>{{number_format($delivery_discount, 2)}}</span>
                            </li>
                            @endif

                            <li class="d-flex justify-content-between">
                                <strong>Net Amount</strong>
                                <strong>{{ number_format($net_amount, 2) }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>

        <div class="modal effect-scale" id="prompt-cancel-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">{{__('Cancel Product')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="id" id="id">
                            <input type="hidden" class="form-control" name="status" id="editStatus">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn-primary">Update</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <form action="" id="posting_form" style="display:none;" method="post">
            @csrf
            <input type="text" id="pages" name="pages">
            <input type="text" id="status" name="status">
        </form>

@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        {{--let searchType = "{{ $searchType }}";--}}
    </script>

{{--    <script src="{{ asset('js/listing.js') }}"></script>--}}
@endsection

@section('customjs')
<script>
    function post_form(id,status,pages){

        $('#posting_form').attr('action',id);
        $('#pages').val(pages);
        $('#status').val(status);
        $('#posting_form').submit();
    }

    {{--function cancel_product(id,status){--}}
    {{--    $('#prompt-cancel-product').modal('show');--}}
    {{--    $('#btnCancelProduct').on('click', function() {--}}
    {{--        //let sales = $('#delivery_status').val();--}}
    {{--        post_form("{{route('sales-transaction.cancel_product')}}",status,id)--}}
    {{--        //console.log(status);--}}
    {{--    });--}}
    {{--}--}}

    $('#prompt-cancel-product').on('show.bs.modal', function (e) {
        //get data-id attribute of the clicked element
        let sales = e.relatedTarget;
        let salesId = $(sales).data('id');
        let salesStatus = $(sales).data('status');
        let formAction = "{{ route('sales-transaction.cancel_product', 0) }}".split('/');
        formAction.pop();
        let editFormAction = formAction.join('/') + "/" + salesId;
        $('#editForm').attr('action', editFormAction);
        $('#id').val(salesId);
        $('#editStatus').val(salesStatus);

    });
</script>
@endsection
