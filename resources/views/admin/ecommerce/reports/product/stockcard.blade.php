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

   
                        <div style="margin:0px 40px 200px 40px;">
                        <h4 class="mg-b-0 tx-spacing--1">{{$id->name}}</h4>
                        <h4 class="mg-b-0 tx-spacing--1">Stock Card Report</h4>
                        
                        <table id="example" class="display nowrap table" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                            <thead>
                            <tr>
                                <th>Transaction</th>
                                <th>Ref#</th>
                                <th>Date</th>
                                <th>Qty</th>
                                <th>Running Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php 
                                 $balance = 0;   
                            @endphp
                            @forelse($rs as $r)
                                @php 
                                    $qty = ($r->type == 'sales' ? ($r->qty * -1) : $r->qty);
                                    $balance = $balance + $qty;
                                @endphp
                                <tr>
                                    <td>{{$r->type}}</td>
                                    <td>{{$r->ref}}</td>
                                    <td>{{$r->created}}</td>
                                    <td>{{number_format($qty,2)}}</td>
                                    <td>{{number_format($balance,2)}}</td>                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No report result.</td>
                                </tr>
                            @endforelse
                                <tr style="font-weight:bold;">
                                    <td colspan="4">Inventory Balance</td>
                                    <td>{{number_format($balance,2)}}</td>
                                </tr>
                            </tbody>

                        </table>
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

</script>
@endsection



