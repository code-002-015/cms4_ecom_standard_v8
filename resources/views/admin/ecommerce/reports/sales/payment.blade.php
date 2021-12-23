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
                    <h4 class="mg-b-0 tx-spacing--1">Sales Payment Report</h4>
              
        
                    <form action="{{route('report.sales.payments')}}" method="get">
                        <input type="hidden" name="act" value="go">
                        @csrf
                        <table>
                            <tr>
                                <td>Payment Start Date: <input type="date" class="form-control" name="start" autocomplete="off" @if(isset($_GET['start'])) value="{{$_GET['start']}}" @endif></td>
                                <td>Payment End Date: <input type="date" class="form-control" name="end" autocomplete="off" @if(isset($_GET['end'])) value="{{$_GET['end']}}" @endif ></td>
                                <td><button type="submit" class="btn btn-primary" style="margin:20px 0px 0px 20px;">Generate</button></td>
                                <td><a href="{{route('report.sales.payments')}}" class="btn btn-success" style="margin:20px 0px 0px 20px;">Reset</a></td>
                            </tr>
                        </table>
                    </form>
                

            @if($rs <>'')
               <br><br>
                        <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                            <thead>
                            <tr>
                                <th>Order number</th>
                                <th>Order Payment Date</th>
                                <th>Customer Name</th>
                                <th>Type of Payment</th>
                                <th>Receipt #</th>
                                <th>Amount Paid</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                            @forelse($rs as $r)
                                <tr>
                                    <td>{{$r->order_number}}</td>
                                    <td>{{$r->payment_date}}</td>
                                    <td>{{$r->customer_name}}</td>
                                    <td>{{$r->payment_type}}</td>
                                   
                                    <td>{{$r->receipt_number}}</td>
                                    <td>{{number_format($r->amount,2)}}</td>                                    
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
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    }
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



