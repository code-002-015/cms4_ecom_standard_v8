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
            <h4 class="mg-b-0 tx-spacing--1">Unpaid Transaction Report</h4>
           
                    <form action="{{route('report.sales.unpaid')}}" method="get">
                        <input type="hidden" name="act" value="go">
                        @csrf
                        <table>
                            <tr>
                                <td>Start Date: <input type="date" class="form-control" name="start" autocomplete="off"></td>
                                <td>End Date: <input type="date" class="form-control" name="end" autocomplete="off"></td>
                                <td><button type="submit" class="btn btn-primary" style="margin:20px 0px 0px 20px;">Generate</button></td>
                            </tr>
                        </table>
                    </form>
             

            @if($rs <>'')
                <br><br>
                        <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                            <thead>
                            <tr>
                                <th>Order#</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Delivery Status</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total Amount</th>

                            </tr>
                            </thead>
                            <tbody>
                                
                            @forelse($rs as $r)
                                <tr>
                                    <td>{{$r->order_number}}</td>
                                    <td>{{$r->hcreated}}</td>
                                    <td>{{$r->customer_name}}</td>
                                    <td>{{$r->product_name}}</td>
                                    <th>{{$r->delivery_status}}</th>
                                    <td>{{number_format($r->price,2)}}</td>
                                    <td>{{number_format($r->qty,2)}}</td>
                                    <td>{{number_format(($r->price * $r->qty),2)}}</td>
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



