@extends('theme.ecommerce.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
@php
    $modals='';
@endphp
<div class="body-overlay"></div>

<div class="content-wrap">
    <div class="container clearfix">
        <div class="row clearfix">
            @include('theme.ecommerce.layouts.sidebar-menu')

            <div class="col-md-9">
                <div class="clear"></div>
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <h3 class="catalog-title">My Orders</h3>
                        <div class="table-history" style="overflow-x:auto;">
                            <table id="salesTransaction" class="table table-hover small text-center overflow-auto">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="align-middle">Order#</th>
                                    <th scope="col" class="align-middle">Date</th>
                                    <th scope="col" class="align-middle">Amount</th>
                                    <th scope="col" class="align-middle">Paid</th>
                                    <th scope="col" class="align-middle">Balance</th>
                                    <th scope="col" class="align-middle">Delivery Status</th>
                                    <th scope="col" class="align-middle">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($sales as $sale)
                                    @php
                                        $paid = \App\Models\SalesHeader::paid($sale->id);
                                        $balance = \App\Models\SalesHeader::balance($sale->id);
                                    @endphp
                                    <tr>
                                        <td>{{$sale->order_number}}</td>
                                        <td>{{$sale->created_at}}</td>
                                        <td>{{number_format($sale->gross_amount,2)}}</td>
                                        <td>{{number_format($paid,2)}}</td>
                                        <td>{{number_format($balance,2)}}</td>
                                        <td>{{$sale->delivery_status}}</td>
                                        <td align="right">
                                            @if($sale->status<>'CANCELLED')
                                                <a href="#" title="view items" onclick="view_items('{{$sale->id}}');" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>
                                                @if ($balance > 0)
                                                    <a href="{{route('my-account.pay-again',$sale->id)}}" title="Pay now" class="btn btn-success btn-sm mb-1"><i class="fa fa-credit-card pb-1"></i></a>&nbsp;
                                                @endif
                                                @if($paid <= 0)
                                                    <a href="#" title="Cancel Order" onclick="cancel_unpaid_order('{{$sale->order_number}}')" class="btn btn-success btn-sm mb-1"><i class="fa fa-exclamation-triangle pb-1"></i></a>&nbsp;
                                                @endif

                                                <a href="#" title="View Deliveries" onclick="view_deliveries('{{$sale->id}}');" class="btn btn-success btn-sm mb-1"><i class="fa fa-truck pb-1"></i></a>
                                            @else
                                                <a href="#" title="view items" data-toggle="modal" data-target="#detail{{$sale->id}}" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $modals .='
                                            <div class="modal fade bs-example-modal-scrollable" id="delivery'.$sale->id.'" tabindex="-1" role="dialog" aria-labelledby="scrollableModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">'.$sale->order_number.'</h4>
                                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="transaction-status">
                                                            </div>
                                                            <div class="gap-20"></div>
                                                            <div class="table-modal-wrap">
                                                                <table class="table table-md table-modal">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Date and Time</th>
                                                                            <th>Status</th>
                                                                            <th>Remarks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>';
                                                                        if($sale->deliveries){
                                                                            foreach($sale->deliveries as $delivery){
                                                                             $modals.='
                                                                                <tr>
                                                                                    <td>'.$delivery->created_at.'</td>
                                                                                    <td>'.$delivery->status.'</td>
                                                                                    <td>'.$delivery->remarks.'</td>
                                                                                </tr>
                                                                            ';
                                                                            }
                                                                        }
                                                                    $modals .='
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="gap-20"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade bs-example-modal-scrollable" id="detail'.$sale->id.'" tabindex="-1" role="dialog" aria-labelledby="scrollableModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">'.$sale->order_number.'</h4>
                                                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="transaction-status">
                                                                <p>Date: '.$sale->created_at.'</p>
                                                                <p>Payment Status: '.$sale->payment_status.'</p>
                                                            </div>
                                                            <div class="gap-20"></div>
                                                            <div class="table-modal-wrap">
                                                                <table class="table table-md table-modal" style="font-size:12px !important;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Product Code</th>
                                                                            <th>Description</th>
                                                                            <th>Qty</th>
                                                                            <th>Price</th>
                                                                            <th>Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>';

                                                                            $total_qty = 0;
                                                                            $total_sales = 0;

                                                                        foreach($sale->items as $item){

                                                                            $total_qty += $item->qty;
                                                                            $total_sales += $item->qty * $item->price;
                                                                            $modals.='
                                                                            <tr>
                                                                                <td>'.$item->product_id.'</td>
                                                                                <td>'.$item->product_name.'</td>
                                                                                <td>'.$item->qty.' '.$item->uom.'</td>
                                                                                <td>'.number_format($item->price,2).'</td>
                                                                                <td>'.number_format(($item->price * $item->qty),2).'</td>
                                                                            </tr>';
                                                                        }
                                                                        $modals.='
                                                                        <tr style="font-weight:bold;">
                                                                            <td colspan="2">Sub total</td>
                                                                            <td>'.number_format($total_qty,2).'</td>
                                                                            <td>&nbsp;</td>
                                                                            <td>'.number_format($total_sales,2).'</td>
                                                                        </tr>
                                                                        <tr style="font-weight:bold;">
                                                                            <td colspan="4">Delivery Fee</td>
                                                                            <td>'.number_format($sale->delivery_fee_amount,2).'</td>
                                                                        </tr>
                                                                        <tr style="font-weight:bold;">
                                                                            <td colspan="4">Grand total</td>

                                                                            <td>'.number_format($total_sales+$sale->delivery_fee_amount,2).'</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="gap-20"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    @endphp
                                @empty
                                    <td>
                                        <div class="alert alert-warning" role="alert">
                                            No Record found
                                        </div>
                                    </td>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div style="float: right">
                            {{ $sales->links('theme.ecommerce.layouts.pagination') }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-scrollable" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="scrollableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable ">
        <div class="modal-content">
            
            <form action="{{route('my-account.cancel-order')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order?</p>
                    <input type="hidden" id="order_number" name="order_number">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="payment_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="ePayment" id="ePayment" action="https://sandbox.ipay88.com.ph/epayment/entry.asp" method="post">
                    <div class="form-group">
                        <label for="Amount" class="col-form-label">Amount to Pay:</label>
                        <input type="number" min="0.00" step="0.01" class="form-control" id="Amount2" name="Amount2">
                    </div>
                    <input type="hidden" name="merchantcode" id="merchantcode" value="PH00125">
                    <input type="hidden" name="paymentid" id="paymentid" value="1">
                    <input type="hidden" name="RefNo" id="RefNo">
                    <input type="hidden" name="Amount" id="Amount">
                    <input type="hidden" name="Currency" id="Currency" value="PHP">
                    <input type="hidden" name="Remark" id="Remark" value="Lydias Lechon Payment">
                    <input type="hidden" name="ProdDesc" id="ProdDesc" value="Lydias Lechon Payment">
                    <input type="hidden" name="UserName" id="UserName" value="{{Auth::user()->email}}">
                    <input type="hidden" name="UserEmail" id="UserEmail" value="{{Auth::user()->email}}">
                    <input type="hidden" name="UserContact" id="UserContact" value="">
                    <input type="hidden" name="ResponseURL" value="https://beta.lydias-lechon.com/ipay_processor.php">
                    <input type="hidden" name="BackendURL" value="https://beta.lydias-lechon.com/ipay_backend.php">
                    <input type="hidden" name="signature" id="signature" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="javascript:void(0)" onclick="paying();" class="btn btn-primary">Pay Now</a>
            </div>
        </div>
    </div>
</div>


{!!$modals!!}

@endsection
@section('pagejs')
    <script src="{{ asset('theme/sysu/plugins/ion.rangeslider/js/ion.rangeSlider.js') }}"></script>
    <script>
        function view_items(salesID){
            $('#delivery'+salesID).modal('show');
        }

        function view_deliveries(salesID){
            $('#detail'+salesID).modal('show');
        }

        function paying(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                data: { amount: $('#Amount2').val(), order: $('#RefNo').val() },
                type: "post",
                url: "",

                success: function(returnData) {

                    if (returnData['success']) {
                        $('#Amount').val(returnData['amount']);
                        $('#UserContact').val(returnData['customer_contact_number']);
                        $('#signature').val(returnData['signature']);
                        $('#ePayment').submit();
                    }
                }
            });
        }

        function pay_now($order,$amt) {
            $('#RefNo').val($order);
            $('#Amount2').val($amt);
            $('#payment_modal').modal('show');
        }

        function cancel_unpaid_order(id){
            $('#cancel_orderid').html('Cancel Order#: '+id);
            $('#order_number').val(id);
            $('#cancel_order').modal('show');
        }
    </script>
@endsection
