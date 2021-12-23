
@foreach($payments as $payment)
    <tr>
        <td>{{$payment->receipt_number}}</td>
        <td>{{$payment->payment_date}}</td>
        <td>{{$payment->payment_type}}</td>
        <td class="text-right">{{number_format($payment->amount,2)}}</td>
        <td>{{$payment->status}}</td>
    </tr>
@endforeach
<tr style="font-weight:bold;">
	<td colspan="3">Total</td>
	<td>{{number_format($payments->sum('amount'),2)}}</td>
</tr>