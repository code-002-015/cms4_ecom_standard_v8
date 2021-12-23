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
         <h4 class="mg-b-0 tx-spacing--1">Sales Summary Report</h4>
                    <form action="{{route('report.sales.summary')}}" method="get">
                        <input type="hidden" name="act" value="go">
                        @csrf
                        <table>
                            <tr>
                                <td>Start</td>
                                <td>End</td> 
                                <td>Delivery Status</td>
                                <td>Customer</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><input type="date" class="form-control input-sm" name="start" autocomplete="off"></td>
                                <td><input type="date" class="form-control input-sm" name="end" autocomplete="off"></td>                                
                                
                                <td>
                                    <select name="delivery_status" id="delivery_status" class="form-control input-sm">
                                        <option value="">Select</option>
                                        <option value="Waiting for Payment">Waiting for Payment</option>
                                        <option value="Scheduled for Processing">Scheduled for Processing</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Ready for Delivery">Ready for Delivery</option>
                                        <option value="In Transit">In Transit</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Returned">Returned</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="customer" id="customer" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $customers = \App\User::where('role_id','6')->orderBy('name')->get();
                                        @endphp
                                        @forelse($customers as $cu)
                                            <option value="{{$cu->id}}">{{$cu->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                               
                                <td><button type="submit" class="btn btn-primary" style="margin:0px 0px 0px 20px;">Generate</button></td>
                            </tr>
                        </table>
                    </form>
            

            @if($rs <>'')
              
                        <br><br>
                        <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                            <thead>
                            <tr>
                                <th align="left">Order#</th>
                                <th align="left">Date</th>
                                <th align="left">Customer</th>                                
                                <th align="left">Delivery Status</th>
                                <th align="left">Payment Status</th>
                                <th align="left">Delivery Fee</th>
                                
                                <th align="left">Amount</th>
                                <th align="left">Total Amount</th>

                            </tr>
                            </thead>
                            <tbody>
                                
                            @php $o = ''; @endphp
                            @forelse($rs as $r)
                                
                                <tr>
                                    <td>{{$r->order_number}}</td>
                                    <td>{{$r->hcreated}}</td>
                                    <td>{{$r->customer_name}}</td>                                    
                                    <th>{{$r->delivery_status}}</th>
                                    <th>{{$r->payment_status}}</th>
                                    <td>{{number_format($r->delivery_fee_amount,2)}}</td>
                                    
                                    <td>{{number_format(($r->gross_amount - $r->delivery_fee_amount),2)}}</td>
                                    <td>{{number_format($r->gross_amount,2)}}</td>
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
                targets: [],
                visible: false
            } ]
        } );
    } );
</script>
@endsection



