<style>
    table {
        font-family:sans-serif;
    }
</style>
<table style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
    <tr>
        <td align="center"><img src="{{ asset('storage').'/logos/'.Setting::getFaviconLogo()->company_logo }}" height="100" alt=""></td>
    </tr>
    <tr>
        <td align="center" style="font-size:18px;font-weight:bold;">Order Details</td>
    </tr>
    <tr>
        <td align="center">TELEPHONE NOS: 939-1221/851-2987 to 88</td>
    </tr>
    <tr>
        <td align="center">REFERENCE #: {{$rs->order_number}}</td>
    </tr>
</table>
<br><br>
<table width="100%">
    <tr>
        <td valign="top">
            <table>
                <tr>
                    <td>Customer Name:</td>
                    <td>{{$rs->customer_name}}</td>
                </tr>                
                <tr>
                    <td>Contact (Tel/Mobile):</td>
                    <td>{{$rs->customer_contact_number}}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{$rs->customer_delivery_adress}}</td>
                </tr>
                <tr>
                    <td>Other Instruction:</td>
                    <td>{{$rs->other_instruction}}</td>
                </tr>               
            </table>
        </td>
        <td valign="top">
            <table>
                <tr>
                    <td>Date:</td>
                    <td>{{date('F d, Y',strtotime($rs->created_at))}}</td>
                </tr>
                <tr>
                    <td>Time:</td>
                    <td>{{date('H:i A',strtotime($rs->update_at))}}</td>
                </tr>
                <tr>
                    <td>Payment Status:</td>
                    <td>{{$rs->Paymentstatus}}</td>
                </tr>
                
            </table>
        </td>
    </tr>
</table>
<br><br><br>
<table style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
    <thead>
        <tr style="font-weight:bold;">
            <td>Item</td>
            <td>Qty</td>
            <td>Amount</td>
            <td>Total</td>

        </tr>
    </thead>
    <tbody>
        <tr><td colspan="5"><hr></td></tr>
        @php
            $total = 0;
        @endphp
        @forelse($rs->items as $r)
        @php
            $total += ($r->price * $r->qty);
        @endphp
        <tr>
            <td>{{$r->product_name}}</td>
            <td>{{number_format($r->qty,2)}}</td>
            <td>{{number_format($r->price,2)}}</td>
            <td>{{number_format(($r->price * $r->qty),2)}}</td>
            
        </tr>
        @empty
        @endforelse
        <tr>
            <td colspan="5"><hr></td>
        </tr>
        <tr>
            <td>Sub Total</td>
            <td colspan="4" align="right">{{number_format($total,2)}}</td>
        </tr>

        @if($rs->discount_amount > 0)
        <tr>
            <td>Coupon Discount</td>
            <td colspan="4" align="right">{{number_format($rs->discount_amount,2)}}</td>
        </tr>
        @endif

        <tr>
            <td>Delivery Fee</td>
            <td colspan="4" align="right">{{number_format($rs->delivery_fee_amount,2)}}</td>
        </tr>
        @php
            $delivery_discount = CouponSale::total_discount_delivery($rs->id);
            $net_amount = ($total-$rs->discount_amount)+($rs->delivery_fee_amount-$delivery_discount);
        @endphp

        @if($delivery_discount > 0)
        <tr>
            <td>Delivery Discount</td>
            <td colspan="4" align="right">{{number_format($delivery_discount,2)}}</td>
        </tr>
        @endif

        <tr>
            <td>Grand Total</td>
            <td colspan="4" align="right">{{number_format($net_amount,2)}}</td>
        </tr>
    </tbody>

</table>

<br><br>
<table width="100%">
    <tr>
        <td align="center" colspan="3">RECEIVED THE ABOVE IN GOOD ORDER AND CONDITION<br><br><br><br></td>
    </tr>
    <tr>
        <td>Receiver<br><br><u>{{$rs->customer_name}}</u></td>
        <td>Signature<br><br> _______________</td>
        <td>Date Time<br><br> _______________</td>
    </tr>
</table>

<script>
    window.addEventListener('load', function() {
        window.print();
    })
</script>

