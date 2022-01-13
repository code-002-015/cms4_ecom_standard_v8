@extends('theme.ecommerce.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
    @php
        $modals='';
    @endphp
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    </div>
    <span onclick="closeNav()" class="dark-curtain"></span>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="desk-cat d-none d-lg-block">
                        <div class="quick-nav">
                            <h3 class="catalog-title">My Account</h3>
                            <ul>
                                <li><a href="{{ route('my-account.manage-account')}}">Manage Account</a></li>
                                <li><a href="{{ route('my-account.update-password') }}">Change Password</a></li>
                                <li class="active"><a href="{{ route('profile.sales') }}">My Orders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <span onclick="openNav()" class="filter-btn d-block d-lg-none pb-3"><i class="fa fa-list"></i> Options</span>
                    <h3 class="catalog-title">Transaction History</h3>

                    @if(isset($_GET['order_cancelled']))
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Important Notice:</h4>
                            <p>The payment transaction you processed was unsuccessful.</p>
                            <hr>
                            <p class="mb-0">If you wish to continue with your order, please click on the corresponding Pay icon <i class="fa fa-credit-card"></i> of Order#: <i style="font-weight:bold;">{{$_GET['order_no']}}</i></p>
                        </div>
                    @endif
                    <div class="table-history" style="overflow-x:auto;">

                        <table class="table table-hover small text-center overflow-auto">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle">Action</th>
                                <th scope="col" class="align-middle">Order#</th>
                                <th scope="col" class="align-middle">Date</th>
                                <th scope="col" class="align-middle">Amount</th>
                                <th scope="col" class="align-middle">Paid</th>
                                <th scope="col" class="align-middle">Balance</th>
                                <th scope="col" class="align-middle">Delivery Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($sales as $sale)
                                @php
                                    $paid = \App\Models\SalesHeader::paid($sale->id);
                                    $balance = \App\Models\SalesHeader::balance($sale->id);
                                @endphp
                                <tr>
                                    <td align="right">
                                        @if($sale->status<>'CANCELLED')
                                            <a href="#" title="view items" data-toggle="modal" data-target="#detail{{$sale->id}}" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>
                                            @if ($balance > 0)
                                                <a href="{{route('my-account.pay-again',$sale->id)}}" title="Pay now" class="btn btn-success btn-sm mb-1"><i class="fa fa-credit-card pb-1"></i></a>&nbsp;
                                            @endif
                                            @if($paid <= 0)
                                                <a href="#" title="Cancel Order" onclick="cancel_unpaid_order('{{$sale->order_number}}')" class="btn btn-success btn-sm mb-1"><i class="fa fa-exclamation-triangle pb-1"></i></a>&nbsp;
                                            @else
                                                <a target="_blank" href="https://forms.office.com/Pages/ResponsePage.aspx?id=XEGiMjf44Uyvp90T9OPGD8Ao7kIPdnhJk-AhXKYQL4JUQkRFMUo0MEEwS0ZDR0hHRFI0NEFVQTVTQy4u" title="Cancel Order" class="btn btn-danger btn-sm mb-1"><i class="fa fa-times pb-1"></i></a>&nbsp;
                                            @endif

                                            <a href="#" title="view delivery history" class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#delivery{{$sale->id}}"><i class="fa fa-truck pb-1"></i></a>
                                        @else
                                            <a href="#" title="view items" data-toggle="modal" data-target="#detail{{$sale->id}}" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>
                                        @endif
                                    </td>
                                    <td>{{$sale->order_number}}</td>
                                    <td>{{$sale->created_at}}</td>
                                    <td>{{number_format($sale->gross_amount,2)}}</td>
                                    <td>{{number_format($paid,2)}}</td>
                                    <td>{{number_format($balance,2)}}</td>
                                    <td>{{$sale->delivery_status}}</td>

                                </tr>
                                @php
                                    $modals .='
                                        <div class="modal fade" id="delivery'.$sale->id.'" tabindex="-1" role="dialog" aria-labelledby="trackModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="trackModalLabel">'.$sale->order_number.'</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
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
                                        <div class="modal fade" id="detail'.$sale->id.'" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel">'.$sale->order_number.'</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
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
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="cancel_order" tabindex="-1" role="dialog" aria-labelledby="cancel_orderid" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('my-account.cancel-order')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancel_orderid"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to cancel this order?</p>
                        <input type="hidden" id="order_number" name="order_number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input class="btn btn-success" type="submit" value="Continue">
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
        $(document).ready(function () {
            $('#salesTransaction').DataTable({
                "responsive": true,
                "columnDefs": [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ],
                "order": [[0, 'desc']],
                "language": {
                    "paginate": {
                        "previous": "&lsaquo;",
                        "next": "&rsaquo;"
                    }
                }
            });
        });

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
