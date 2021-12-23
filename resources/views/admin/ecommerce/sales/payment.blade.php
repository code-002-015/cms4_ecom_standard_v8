@extends('admin.layouts.app')

@section('pagetitle')
    Gift Certificate Manager
@endsection

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>
        .row-selected {
            background-color: #92b7da !important;
        }
    </style>
@endsection

@section('content')

<!-- container start-->
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{route('sales-transaction.index')}}">Sales Transaction</a></li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1"> Payment Summary</h4>
        </div>.
        <div>
            <a href="{{ route('sales-transaction.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Back</a>
        </div>
    </div>

    <div class="row row-sm">
        <div class="table-responsive mg-t-20">
            <table class="table table-invoice bd-b">
                <thead>
                <tr>
                    <th class="tx-center">Payment Type</th>
                    <th class="tx-center">Status</th>
                    <th class="tx-center">Payment Date</th>
                    <th class="tx-center">Receipt Number</th>
                    <th class="tx-center">Remarks</th>
                    <th class="tx-center">Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($salesPayments as $payment)
                    <tr>
                        <td class="tx-center">{{$payment->payment_type}}</td>
                        <td class="tx-center">{{$payment->status}}</td>
                        <td class="tx-center">{{ date('F d, Y', strtotime($payment->payment_date))}}</td>
                        <td class="tx-center">{{$payment->receipt_number}}</td>
                        <td class="tx-center">{{$payment->remarks}}</td>
                        <td class="tx-center">{{number_format($payment->amount, 0)}}</td>

                    </tr>
                @empty
                    <tr>
                        <td class="tx-center " colspan="6">No transaction found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <p class="tx-right" >Total Net Amount: {{number_format($totalNet, 0)}}</p>
            <p class="tx-right" >Total Payment Amount: {{number_format($totalPayment, 0)}}</p>
            <p class="tx-right" >Remaining Balance: {{number_format($remainingPayment, 0)}}</p>
        </div>
    </div>
    <!-- row -->
</div>
<!-- container -->
</div>



@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        {{--let searchType = "{{ $searchType }}";--}}
    </script>

    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')

@endsection
