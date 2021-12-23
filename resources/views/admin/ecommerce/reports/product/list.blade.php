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
        <h4 class="mg-b-0 tx-spacing--1">Product List</h4>
        <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Added Date</th>                                
                    <th>Price</th>
                    <th>Size</th>
                    <th>Weight</th>
                    <th>UoM</th>  
                    <th>Short Description</th>
                    <th>Description</th>                             

                </tr>
            </thead>
            <tbody>
            @forelse($rs as $r)
                <tr>
                    <td>{{$r->name}}</td>
                    <td>{{$r->code}}</td>
                    <td>{{$r->brand}}</td>
                    <td>{{$r->category->name}}</td>
                    <td>{{$r->created_at}}</td>
                    <td>{{$r->price}}</td>
                    <td>{{$r->size}}</td>
                    <td>{{$r->weight}}</td>
                    <td>{{$r->uom}}</td>
                    <td>{{$r->short_description}}</td>
                    <td>{!! strip_tags($r->description) !!}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No report result.</td>
                </tr>
            @endforelse
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
                    targets: 10,
                    visible: false
                } ]
            } );
        } );
    </script>
@endsection



