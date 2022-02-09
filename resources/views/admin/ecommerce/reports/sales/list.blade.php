@extends('admin.layouts.report')

@section('pagetitle')

@endsection

@section('pagecss')
    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">

    <style>
        .row-selected {
            background-color: #92b7da !important;
        }
    </style>
@endsection

@section('content')

  
                    
               
<div style="margin:0px 40px 200px 40px;font-family:Arial;">
         <h4 class="mg-b-0 tx-spacing--1">Sales Report</h4>
                    <form action="{{route('report.sales.list')}}" method="get">
                        <input type="hidden" name="act" value="go">
                        @csrf
                        <table style="font-size:12px;">
                            <tr>
                                <td>Order Start Date</td>
                                <td>Order End Date</td>
                                <td>Category</td>
                                <td>Brand</td>
                                <td>Product</td>
                                <td>Customer</td>
                                <td>Delivery Status</td>
                                <td>Payment Status</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="start" autocomplete="off"
                                    @if(isset($_GET['start'])) value="{{$_GET['start']}}" @endif >
                                </td>
                                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="end" autocomplete="off"
                                    @if(isset($_GET['end'])) value="{{$_GET['end']}}" @endif >
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="category" id="category" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $categories = \App\Models\ProductCategory::orderBy('name')->get();
                                        @endphp
                                        @forelse($categories as $c)
                                            <option value="{{$c->id}}" 
                                                @if(isset($_GET['category']) and $_GET['category']==$c->id) selected="selected" @endif 
                                            >
                                                {{$c->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="brand" id="brand" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $brands = \App\Models\Product::distinct()->select('brand')->orderBy('brand')->get();
                                        @endphp
                                        @forelse($brands as $b)
                                            <option value="{{$b->brand}}"
                                                @if(isset($_GET['brand']) and $_GET['brand']==$b->brand) selected="selected" @endif 
                                            >
                                                {{$b->brand}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="product" id="product" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $products = \App\Models\Product::orderBy('name')->get();
                                        @endphp
                                        @forelse($products as $p)
                                            <option value="{{$p->id}}"
                                                @if(isset($_GET['product']) and $_GET['product']==$p->id) selected="selected" @endif 
                                            >
                                                {{$p->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="customer" id="customer" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $customers = \App\User::where('role_id','6')->orderBy('name')->get();
                                        @endphp
                                        @forelse($customers as $cu)
                                            <option value="{{$cu->id}}"
                                                @if(isset($_GET['customer']) and $_GET['customer']==$cu->id) selected="selected" @endif 
                                            >
                                                {{$cu->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="del_status" id="del_status" class="form-control input-sm">
                                        <option value="">Select</option>
                                        <option value="Waiting for Payment">Waiting for Payment</option>
                                        <option value="Scheduled for Processing">Scheduled for Processing</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Ready For delivery">Ready For delivery</option>
                                        <option value="In Transit">In Transit</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Returned">Returned</option>
                                        <option value="Cancelled">Cancelled</option>
                                        @if(isset($_GET['del_status']))
                                            <option value="{{$_GET['del_status']}}" selected="selected">{{$_GET['del_status']}}</option>
                                        @endif 
                                     
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 80px;" name="payment_status" id="payment_status" class="form-control input-sm">
                                        <option value="">All</option>
                                        <option value="PAID" @if(isset($_GET['payment_status']) and $_GET['payment_status']=="PAID") selected="selected" @endif>PAID</option>
                                        <option value="UNPAID" @if(isset($_GET['payment_status']) and $_GET['payment_status']=="UNPAID") selected="selected" @endif>UNPAID</option>
                                    </select>
                                </td>
                                <td><button type="submit" class="btn btn-primary" style="margin:0px 0px 0px 20px;">Generate</button></td>
                                <td><a href="{{ route('report.sales.list') }}" class="btn btn-success" style="margin:0px 0px 0px 20px;">Reset</a></td>
                            </tr>
                        </table>
                    </form>
            

            @if($rs <>'')
              
                        <br><br>
                        <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                            <thead>
                            <tr>
                                <th align="left">Order#</th>
                                <th align="left">Order Date</th>
                                <th align="left">Payment Date</th>
                                <th align="left">Customer</th>
                                <th align="left">Code</th>
                                <th align="left">Product</th>
                                <th align="left">Delivery Fee</th>
                                <th align="left">Price</th>
                                <th align="left">Qty</th>
                                <th align="left">Total Amount</th>
                                <th align="left">Voucher Code</th>
                                <th align="left">Voucher Amount</th>
                                <th align="left">Order Status</th>
                                <th align="left">Shipping Option</th>
                                <th align="left">Trucking#</th>
                                <th align="left">Brand</th>
                                <th align="left">Contact no</th>
                                <th align="left">Address</th>
                                <th align="left">Category</th>
                                <th align="left">Payment Status</th>
                                <th>Customer Type</th>
                                <th>Coupons</th>
                                
                                
                                

                            </tr>
                            </thead>
                            <tbody>
                                
                            @php $o = ''; @endphp
                            @forelse($rs as $r)
                                @php
                                    $del_fee=0;                                    
                                    if($o<>$r->order_number){
                                        $del_fee=$r->delivery_fee_amount;
                                        $o=$r->order_number;
                                    }
                                @endphp
                                <tr>
                                    <td>{{$r->order_number}}</td>
                                    <td>{{$r->hcreated}}</td>
                                    <th>{{$r->pdate}}</th>
                                    <td>{{$r->customer_name}}</td>
                                    <td>{{$r->code}}</td>
                                    <td>{{$r->product_name}}</td>
                                    <td>{{number_format($del_fee,2)}}</td>
                                    <td>{{number_format($r->price,2)}}</td>
                                    <td>{{number_format($r->qty,2)}}</td>
                                    <td>{{number_format(($r->price * $r->qty)+$del_fee,2)}}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>{{$r->delivery_status}}</td>
                                    <td>@if($r->delivery_status == 'd2d') Door to door @elseif($r->delivery_status == 'storepickup')Store Pickup @endif</td>
                                    <td>{{$r->delivery_tracking_number}}</td>
                                    <td>{{$r->brand}}</td>
                                    <td>{{$r->customer_contact_number}}</td>
                                    <td>{{$r->customer_delivery_adress}}</td>                                    
                                    <td>{{$r->catname}}</td>
                       
                                    <th>{{$r->payment_status}}</th>
                                    <td>{{ ucwords($r->customer_type) }}</td>
                                    <td>{{ \App\Models\CouponSale::coupons_used_on_sales($r->hid) }}</td>
                                   
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No report result.</td>
                                </tr>
                            @endforelse

                            </tbody>

                        </table>
                   
            @endif

        </div>
    

@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/prismjs/prism.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>

@endsection

@section('customjs')
<script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.colVis.min.js') }}"></script>
<script>
  

    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            pageLength: 20,
            order: [[0,'desc']],
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                 // {
                //     extend: 'pdf',
                //     exportOptions: {
                //         columns: ':visible'
                //     }
                // },
                {   
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    },
                    orientation : 'landscape',
                    pageSize : 'LEGAL'
                },
                'colvis'
            ],
            columnDefs: [ {
                targets: [6,10,11,12,13,14,15,16,17,18,19],
                visible: false
            } ]
        } );
    } );
</script>
@endsection



