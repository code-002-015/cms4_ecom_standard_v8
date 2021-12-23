@extends('admin.layouts.app')

@section('pagetitle')
    Sales Transaction Manager
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('js/datatables/datatables.css') }}">
    <style>
        .row-selected {
            background-color: #92b7da !important;
        }
        div.dt-buttons {
          font: normal bold 12px/30px Arial, serif;
        }
        .paginate_button {
            font: normal bold 12px/30px Arial, serif;
        }
        .dataTables_info {
            font: normal bold 12px/30px Arial, serif;
        }
        .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody {
          overflow-y: scroll !important;
        }
    </style>
@endsection

@section('content')

    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-5" style="background-color:white;">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sales Transaction</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Sales Transaction Manager</h4>
            </div>
        </div>

        <div class="row row-sm">

            <!-- Start Filters -->
            <div class="col-md-12">
                <div class="filter-buttons">
                    <div class="d-md-flex bd-highlight">
                        <div class="bd-highlight mg-r-10 mg-t-10" style="display:none;">
                            <div class="dropdown d-inline mg-r-5">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('common.filters')}}
                                </button>
                                <div class="dropdown-menu">
                                    <form id="filterForm" class="pd-20">
                                       
                                        
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if ($filter->showDeleted) checked @endif>
                                                <label class="custom-control-label" for="showDeleted">{{__('common.show_deleted')}}</label>
                                            </div>
                                        </div>
                                        
                                        <button id="filter" type="button" class="btn btn-sm btn-primary" style="dispaly:none;">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="bd-highlight mg-t-10 mg-r-5">
                            <form class="form-inline" id="searchForm" style="font-size:12px;">
                             
                                    <div class="mg-b-10 mg-r-5">Start:
                                        <input name="startdate" type="date" id="startdate" style="font-size:12px;width: 150px;" class="form-control"
                                        value="@if(isset($_GET['startdate'])  && strlen($_GET['startdate'])>1){{ date('Y-m-d',strtotime($_GET['startdate'])) }}@endif">
                                    </div>
                                    <div class="mg-b-10">End:
                                        <input name="enddate" type="date" id="enddate" style="font-size:12px;width: 150px;" class="form-control"
                                        value="@if(isset($_GET['enddate'])  && strlen($_GET['enddate'])>1 ){{ date('Y-m-d',strtotime($_GET['enddate'])) }}@endif">
                                    </div>
                                    &nbsp;
                                    <div class="mg-b-10">
                                        <select name="del_status" id="del_status" class="form-control" style="font-size:12px;width: 150px;">
                                            <option value="">Delivery Status</option>
                                            <option value="Waiting for Payment">Waiting for Payment</option>
                                            <option value="Scheduled for Processing">Scheduled for Processing</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Ready For delivery">Ready For delivery</option>
                                            <option value="In Transit">In Transit</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Returned">Returned</option>
                                            <option value="Cancelled">Cancelled</option>
                                            @if(isset($_GET['del_status']) && strlen($_GET['del_status'])>1)
                                                <option value="{{$_GET['del_status']}}" selected="selected">{{$_GET['del_status']}}</option>
                                            @endif 
                                        </select>
                                    </div>
                                    &nbsp;
                                    <div class="mg-b-10 mg-r-5">
                                        <select name="customer_filter" id="customer_filter" class="form-control" style="font-size:12px;width: 150px;">
                                                <option value="">Customer</option>
                                                @foreach($sales->unique('customer_name')->sortBy('customer_name') as $cname)
                                                    <option value="{{$cname->customer_name}}"
                                                    @if(isset($_GET['customer_filter']) and $_GET['customer_filter']==$cname->customer_name) selected="selected" @endif 
                                                        >{{$cname->customer_name}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    

                                    {{-- <div class="mg-b-10 mg-r-5">
                                        <input name="search" type="search" id="search" class="form-control" style="font-size:12px;width: 150px;"  placeholder="Search all columns" value="{{ $filter->search }}">
                                    </div> --}}
                                    
                                    <div class="mg-b-10">
                                        <button class="btn btn-sm btn-info" type="button" id="btnSearch">Search</button>
                                        <a class="btn btn-sm btn-success" href="{{route('sales-transaction.index')}}">Reset</a>
                                    </div>
                              

                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Filters -->


            <!-- Start Pages -->
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <table class="table mg-b-0 table-light table-hover" id="table_sales">
                        <thead>
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox" style="position:relative;left:-8px;">
                                    <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                    <label class="custom-control-label" for="checkbox_all"></label>
                                </div>
                            </th>
                            <th>Order #</th>
                            <th>Order Date</th>
                            <th>Payment Date</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                            <th>Payment Status</th> 
                            <th class="exclude_export">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @forelse($sales as $sale)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input cb" id="cb{{ $sale->id }}" value="{{ $sale->id }}">
                                        <label class="custom-control-label" for="cb{{ $sale->id }}"></label>
                                    </div>
                                </td>
                                <td> <strong @if($sale->trashed()) style="text-decoration:line-through;" @endif> {{$sale->order_number }}<br></strong></td>
                                <td>{{ $sale->created_at }}</td>
                                <td>
                                    @if(SalesPayment::check_if_has_added_payments($sale->id) == 1)
                                        @php
                                            $last_paid = SalesPayment::where('sales_header_id',$sale->id)->orderBy('payment_date','desc')->first();
                                        @endphp
                                        {{ date('Y-m-d',strtotime($last_paid->payment_date) )}}
                                    @endif
                                </td>
                                <td>{{ $sale->customer_name }}</td>
                                <td>
                                    @if(SalesPayment::check_if_has_added_payments($sale->id) == 1)
                                        <a href="javascript:;" onclick="show_added_payments('{{$sale->id}}');">{{ number_format($sale->net_amount,2) }}</a>
                                    @else
                                        {{ number_format($sale->net_amount,2) }}
                                    @endif
                                </td>
                                <td><a href="{{route('admin.report.delivery_report',$sale->id)}}" target="_blank">{{$sale->delivery_status}}</a></td>
                                <td>{{ $sale->Paymentstatus }}</td>
                                <td>
                                    <nav class="nav table-options">
                                        @if($sale->trashed())
                                            <nav class="nav table-options">
                                                <a class="nav-link" href="{{route('sales-transaction.restore',$sale->id)}}" title="Restore this Sales Transaction"><i data-feather="rotate-ccw"></i></a>
                                            </nav>
                                        @else

                                            <a class="nav-link" target="_blank" href="{{ route('sales-transaction.view',$sale->id) }}" title="View Page"><i data-feather="eye"></i></a>
                                            <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-feather="settings"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if($sale->status == 'UNPAID')
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#prompt-change-status" title="Update Sales Transaction" data-id="{{$sale->id}}" data-status="PAID">Paid</a>
                                                @else
                                                @endif

                                                @if($sale->status<>'CANCELLED')
                                                    @if (auth()->user()->has_access_to_route('sales-transaction.delivery_status'))
                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="change_delivery_status({{$sale->id}})" title="Update Delivery Status" data-id="{{$sale->id}}">Update Delivery Status</a>
                                                    @endif
                                                @endif
                                                <a class="dropdown-item disallow_when_multiple_selected" href="javascript:void(0);" onclick="show_delivery_history({{$sale->id}})" title="Update Delivery Status" data-id="{{$sale->id}}">Show Delivery History</a>
                                                <a class="dropdown-item disallow_when_multiple_selected" target="_blank" href="{{ route('sales-transaction.view_payment',$sale->id) }}" title="Show payment" data-id="{{$sale->id}}">Sales Payment</a>

                                                @if(SalesPayment::check_if_has_remaining_balance($sale->gross_amount,$sale->id) == 1)
                                                    @if($sale->status<>'CANCELLED')
                                                        @if (auth()->user()->has_access_to_route('payment.add.store'))
                                                            <a class="dropdown-item disallow_when_multiple_selected" href="javascript:;" onclick="addPayment('{{$sale->id}}','{{SalesPayment::remaining_balance($sale->gross_amount,$sale->id)}}');">Add Payment</a>
                                                        @endif
                                                    @endif
                                                @endif

                                                @if($sale->status<>'CANCELLED')
                                                    @if (auth()->user()->has_access_to_route('sales-transaction.destroy'))
                                                        <a class="dropdown-item text-danger disallow_when_multiple_selected" href="javascript:void(0)" onclick="delete_sales({{$sale->id}},'{{$sale->order_number}}')" title="Cancel Transaction">Cancel</a>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    </nav>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="17" style="text-align: center;"> <p class="text-danger">No Sales Transaction found.</p></th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Pages -->
            <div class="col-md-6" style="display:none;">
                <div class="mg-t-5">
                    @if ($sales->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6" style="display:none;">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $sales->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="pages" name="pages">
        <input type="text" id="status" name="status">
    </form>

    @include('admin.ecommerce.sales.modals')
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>


    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/datatables/JSZip-2.5.0/jszip.min.js') }}"></script>
    <script src="{{ asset('js/datatables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/datatables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.print.min.js') }}"></script>
    <script>
        //var dateToday = new Date();
        $(function(){
            'use strict'

            $('#payment_dt').datepicker({
                //minDate: dateToday,
                dateFormat: 'yy-mm-dd',
            });
        });
    </script>

    <script>
        let listingUrl = "{{ route('sales-transaction.index') }}";
        let searchType = "{{ $searchType }}";
    </script>

    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
    <script>

        function delete_sales(x,order_number){
            $('#frm_delete').attr('action',"{{route('sales-transaction.destroy',"x")}}");
            $('#id_delete').val(x);
            $('#delete_order_div').html(order_number);
            $('#prompt-delete').modal('show');
        }
        function addPayment(id,balance){
            $('#prompt-add-payment').modal('show');
            $('#sales_header_id').val(id);
            $("#payment_amount").attr({
                "max" : balance
            });
        }

        function show_added_payments(id){
            $.ajax({
                type: "GET",
                url: "{{ route('display.added-payments') }}",
                data: { id : id },
                success: function( response ) {
                    $('#added_payments_tbl').html(response);
                    $('#prompt-show-added-payments').modal('show');
                }
            });
        }

        function show_delivery_history(id){
            $.ajax({
                type: "GET",
                url: "{{ route('display.delivery-history') }}",
                data: { id : id },
                success: function( response ) {
                    $('#delivery_history_tbl').html(response);
                    $('#prompt-show-delivery-history').modal('show');
                }
            });
        }

        function post_form(id,status,pages){

            $('#posting_form').attr('action',id);
            $('#pages').val(pages);
            $('#status').val(status);
            $('#posting_form').submit();
        }

        $(".js-range-slider").ionRangeSlider({
            grid: true,
            from: selected,
            values: perPage
        });

        /*** Handles the Select All Checkbox ***/
        $("#checkbox_all").click(function(){
            $('.cb').not(this).prop('checked', this.checked);
        });

        $('#prompt-change-status').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            let sales = e.relatedTarget;
            let salesId = $(sales).data('id');
            let salesStatus = $(sales).data('status');
            let formAction = "{{ route('sales-transaction.quick_update', 0) }}".split('/');
            formAction.pop();
            let editFormAction = formAction.join('/') + "/" + salesId;
            $('#editForm').attr('action', editFormAction);
            $('#id').val(salesId);
            $('#editStatus').val(salesStatus);

        });

        function change_delivery_status(id){
            var checked = $('.cb:checked');
            
            var count = checked.length;

            if(count == 1){
                checked.each(function () {
                    $('#del_id').val($(this).val());
                });

            }
            if(count > 1) {

                var ids = [];
                checked.each(function(){
                    ids.push(parseInt($(this).val()));
                });

                $('#del_id').val(ids.join(','));
            }
            if(count < 1){
                $('#del_id').val(id);
            }

            $('#prompt-change-delivery-status').modal('show');
            // $('#del_id').val(id);


            // $('#btnChangeDeliveryStatus').on('click', function() {
            //     let sales = $('#delivery_status').val();
            //     post_form("{{route('sales-transaction.delivery_status')}}",sales,id)
            // });
        }



    </script>

    <script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var tablea = $('#table_sales').DataTable( {
                dom: 'Bfrtip',
                aaSorting: [3,1],
                sDom: 'lrtip',
                pageLength: 20,
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
                            columns: ':not(.exclude_export)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ],
                columnDefs: [{
                    targets: [],
                    visible: false
                }]
            } );
            //$('#table_sales_filter').hide();
            @if(isset($_GET['deliverystatus']))
                $('#table_sales').DataTable().search( "{{$_GET['deliverystatus']}}" ).draw();
            @endif
        } );

        // $('#del_status').on('change', function(){            
        //     $('#table_sales').DataTable().search( this.value ).draw();
        // });

        $('#search').on('keyup', function(){            
            $('#table_sales').DataTable().search( this.value ).draw();
        });

        // $('#customer_filter').on('change', function(){            
        //     $('#table_sales').DataTable().columns( 2 ).search( this.value ).draw();
        // });

        $(".cb").change(function() {
            var checked = $('.cb:checked');
            
            var count = checked.length;

            if(count > 1){                 
                $('.disallow_when_multiple_selected').hide();
            }
            else{
                $('.disallow_when_multiple_selected').show();
            }
        });

        $("#checkbox_all").change(function() {
            var checked = $('.cb:checked');            
            var count = checked.length;
            if(count > 1){                 
                $('.disallow_when_multiple_selected').hide();
            }
            else{
                $('.disallow_when_multiple_selected').show();
            }
        });
        


    </script>
@endsection
