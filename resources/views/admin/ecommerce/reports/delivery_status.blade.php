@extends('admin.layouts.report')




@section('content')
    
    <div class="container">
        <h1>Delivery Status Report</h1>
        <div class="row">
            <div class="col-md-12">
                <table width="100%">
                    <tr>
                        <td>Start: <input type="date" name="startdate" class="form-control"></td>
                        <td>End: <input type="date" name="startdate" class="form-control"></td>
                        
                        <td><br><input type="submit" value="Generate" class="btn btn-lg btn-success"></td>
                    </tr>
                </table>
               
            </div>
        </div>
        @if(isset($rs))
        <br><br><br>
            <div class="row row-sm">
                <!-- Start Filters -->
                <div class="col-md-12">
                    <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                        <thead>
                            <tr>
                                <th>Order#</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Delivery Address</th>
                                <th>Delivery Status</th>
                                <th>Product</th>
                                <th>Qty</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rs as $r)
                            <tr>
                                <td>{{$r->order_number}}</td>
                                <td>{{$r->hcreated}}</td>
                                <td>{{$r->customer_name}}</td>
                                <td>{{$r->customer_delivery_adress}}</td>
                                <td>{{$r->delivery_status}}</td>
                                <td>{{$r->product_name}}</td>
                                <td>{{number_format($r->qty,2)}}</td>
                            </tr>
                            @empty
                            @endforelse
                            
                        </tbody>
                     
                    </table>
                </div>
                <!-- End Filters -->           
            </div>
        @endif
    </div>   



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



