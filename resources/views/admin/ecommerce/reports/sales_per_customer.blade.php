@extends('admin.layouts.report')

@section('content')
    
    <div class="container">
        <br>
        <div class="text-center"><h5>Sales per Agent Report</h5></div><br>
        <div class="row">
            <div class="col-md-12">
                <form>
                <table width="100%" style="font-size:12px;font-family:Arial;">
                    <tr>
                        <td>Agents:
                            <select name="customer" id="customer" class="form-control">
                                <option value="">Select Customer</option>
                                @forelse($customers as $c)
                                    <option value="{{$c->customer_name}}">{{$c->customer_name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </td>
                        <td>Start: <input type="date" name="startdate" class="form-control input-sm "></td>
                        <td>End: <input type="date" name="enddate" class="form-control input-sm "></td>                        
                        <td><br><input type="submit" value="Generate" class="btn btn-md btn-success"></td>
                    </tr>
                </table>
                </form>
               
            </div>
        </div>
        <br><br>
        @if(isset($rs))
            <div class="row row-sm">
                <!-- Start Filters -->
                <div class="col-md-12">
                    <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                        <thead>
                        <tr>
                            <th>Order#</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Product</th>
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
                                <td>{{number_format($r->price,2)}}</td>
                                <td>{{number_format($r->qty,2)}}</td>
                                <td>{{number_format(($r->price * $r->qty),2)}}</td>
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



