@extends('admin.layouts.app')

@section('pagecss')
<style>
    .table-dashboard-one tbody td {
        padding-top: 10px;
        padding-bottom: 10px; 
    }
</style>
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item active" aria-current="page">Ecommerce Dashboard</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Welcome, {{ Auth::user()->firstname }}!</h4>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12 mg-t-10">
            <div class="card ht-100p">
                <div class="card-body">
                    <input type="hidden" id="line_months" value="{{$months}}">
                    <input type="hidden" id="arr_yrs" value="{{$arr_yrs}}">
                    <input type="hidden" id="yr1" value="{{$year1}}">
                    <input type="hidden" id="yr2" value="{{$year2}}">
                    <input type="hidden" id="yr3" value="{{$year3}}">
                    <div class="ht-260 ht-lg-400"><canvas id="chartLine1"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-12 mg-t-20">
            <div class="card card-body">
                <div class="d-md-flex align-items-center justify-content-between">
                    <div class="media align-sm-items-center">
                        <div class="media-body">
                            <h6 class="tx-12 tx-lg-14 tx-semibold tx-uppercase tx-spacing-1 mg-b-5">Filter By : </h6>
                            <a href="{{route('ecom-dashboard')}}?filter=sales&@if(isset($_GET['data_from']))data_from={{ $_GET['data_from'] }}@if($_GET['data_from'] == 'custom_date')&startdate={{$_GET['startdate']}}&enddate={{$_GET['enddate']}} @endif @endif" class="btn btn-sm @if(!isset($_GET['filter']) || isset($_GET['filter']) && $_GET['filter'] == 'sales') btn-primary @else btn-white @endif btn-uppercase pd-x-15 mg-b-5">Sales</a>

                            <a href="{{route('ecom-dashboard')}}?filter=orders&@if(isset($_GET['data_from']))data_from={{ $_GET['data_from'] }}@if($_GET['data_from'] == 'custom_date')&startdate={{$_GET['startdate']}}&enddate={{$_GET['enddate']}} @endif @endif" class="btn btn-sm @if(isset($_GET['filter']) && $_GET['filter'] == 'orders') btn-primary @else btn-white @endif btn-uppercase pd-x-15 mg-b-5 mg-t-5 mg-sm-t-0 mg-sm-l-5">Orders</a>

                            <a href="{{route('ecom-dashboard')}}?filter=volume&@if(isset($_GET['data_from']))data_from={{ $_GET['data_from'] }}@if($_GET['data_from'] == 'custom_date')&startdate={{$_GET['startdate']}}&enddate={{$_GET['enddate']}} @endif @endif" class="btn btn-sm @if(isset($_GET['filter']) && $_GET['filter'] == 'volume') btn-primary @else btn-white @endif btn-uppercase pd-x-15 mg-b-5 mg-t-5 mg-sm-t-0 mg-sm-l-5">Volumes</a>
                        </div>
                    </div>
                    <div class="mg-t-20 mg-md-t-0">
                        <h6 class="tx-12 tx-lg-14 tx-semibold tx-uppercase tx-spacing-1 mg-b-5">Generate By : </h6>
                        <a href="{{route('ecom-dashboard')}}?data_from=today" class="btn btn-sm btn-uppercase pd-x-15 mg-b-5 @if(isset($_GET['data_from']) && $_GET['data_from'] == 'today') btn-primary @else btn-white @endif btn-uppercase">Today</a>

                        {{--<a href="{{route('ecom-dashboard')}}?data_from=last_7_days" class="btn btn-sm btn-uppercase pd-x-15 mg-b-5 @if(isset($_GET['data_from']) && $_GET['data_from'] == 'last_7_days') btn-primary @else btn-white @endif btn-uppercase">Last 7 Days</a>--}}

                        <a href="{{route('ecom-dashboard')}}?data_from=last_30_days" class="btn btn-sm btn-uppercase pd-x-15 mg-b-5 @if(isset($_GET['data_from']) && $_GET['data_from'] == 'last_30_days') btn-primary @else btn-white @endif btn-uppercase">Last 30 Days</a>

                        <a href="{{route('ecom-dashboard')}}?data_from=month_to_date" class="btn btn-sm btn-uppercase pd-x-15 mg-b-5 @if(isset($_GET['data_from']) && $_GET['data_from'] == 'month_to_date' || !isset($_GET['data_from'])) btn-primary @else btn-white @endif btn-uppercase">Month to Date</a>

                        <a href="{{route('ecom-dashboard')}}?data_from=last_month" class="btn btn-sm pd-x-15 mg-b-5 @if(isset($_GET['data_from']) && $_GET['data_from'] == 'last_month') btn-primary @else btn-white @endif btn-uppercase">Last Month</a>

                        <a href="#modalBillingInfo" data-toggle="modal" class="btn btn-sm btn-uppercase pd-x-15 mg-b-5 @if(isset($_GET['data_from']) && $_GET['data_from'] == 'custom_date') btn-primary @else btn-white @endif">Custom Date</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mg-t-10">
            <div class="alert alert-primary mg-b-0" role="alert">
                Data shown below from <a href="#" class="alert-link">{{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }}</a>  to <a href="#" class="alert-link">{{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</a>
            </div>
        </div>

        <div class="col-lg-12 mg-t-10">
            <div class="card">
                <div class="card-body pos-relative pd-20">
                    <div class="chart-one">
                        <input type="hidden" id="top_prod_names" value="{{$top_prod_names}}">
                        <input type="hidden" id="top_prod_earnings" value="{{$top_prod_earnings}}">
                        <div class="ht-250 ht-lg-400"><canvas id="chartBar1"></canvas></div>
                    </div>
                </div>
                <div class="card-footer text-center tx-13">
                    <a href="{{ route('admin.report.top_products') }}?startdate={{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}&enddate={{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}" target="_blank" class="link-03">View All Records <i class="icon ion-md-arrow-forward mg-l-5"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mg-t-10">
            <div class="card">
                <div class="card-body pd-y-25">
                    <div class="col-12">
                        <div class="chart-thirteen"><canvas id="chartDonut"></canvas></div>
                    </div>
                    <div class="col-12 tx-12 mg-t-40">
                        @php
                            $colors = '';
                            $labels = '';
                            $values = '';
                            $total_sales = 0;
                        @endphp
                        @foreach($top_soc_media as $med)

                        @php

                            $total_sales += $med->filtered_value;
                            $values .= $med->filtered_value.'|';

                            if($med->origin != ''){
                                $l = ucwords($med->origin);
                            } else {
                                $l = 'Others';
                            }

                            $labels .= $l.'|';
                            $color = \App\Models\SalesHeader::media_color($l);
                            $colors .= $color.'|';
                        @endphp
                        <div class="d-flex align-items-center mg-t-10">
                            <div class="wd-10 ht-10 rounded-circle pos-relative t--1" style="background-color:{{$color}}"></div>
                            <span class="tx-medium mg-l-10">{{ ucwords($l) }}</span>
                            <span class="tx-rubik mg-l-auto">
                                @isset($_GET['filter'])
                                    @if($_GET['filter'] == 'sales')
                                        ₱ {{ number_format($med->filtered_value,2) }}
                                    @else
                                        {{ number_format($med->filtered_value,0) }}
                                    @endif
                                @else
                                    ₱ {{ number_format($med->filtered_value,2) }}
                                @endif
                            </span>
                        </div>
                        @endforeach
                        <input type="hidden" id="per_channel_colors" value="{{ $colors }}">
                        <input type="hidden" id="per_channel_labels" value="{{ $labels }}">
                        <input type="hidden" id="per_channel_revenues" value="{{ $values }}">
                        <input type="hidden" id="total_channel_revenues" value="{{ $total_sales }}">
                    </div>
                </div>
                <div class="card-footer text-center tx-13">
                    <a href="{{ route('admin.report.sales_social') }}?startdate={{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}&enddate={{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}" target="_blank" class="link-03">View All Channels <i class="icon ion-md-arrow-forward mg-l-5"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mg-t-10">
            <div class="card">
                <div class="card-body">
                        <div class="col-12">
                            <div class="chart-thirteen"><canvas id="chartCategory"></canvas></div>
                        </div>
                        <div class="col-12 tx-12 mg-t-40">
                            @php
                                $cat_colors = '';
                                $cat_labels = '';
                                $cat_values = '';
                                $total_cat_sales = 0;
                            @endphp

                            @foreach($top_selling_categories as $order)

                            @php
                                $total_cat_sales += $order->filtered_value;
                                $cat_values .= $order->filtered_value.'|';

                                $cat_labels .= $order->name.'|';

                                $cat_color = \App\Models\SalesHeader::random_color();
                                $cat_colors .= $cat_color.'|';

                            @endphp

                            <div class="d-flex align-items-center mg-t-10">
                                <div class="wd-10 ht-10 rounded-circle pos-relative t--1" style="background-color:{{$cat_color}};"></div>
                                @if($order->product_category == '' || $order->product_category == 0)
                                    <span class="tx-medium mg-l-10">Uncategorized</span>
                                @else
                                    <span class="tx-medium mg-l-10">{{ ucwords($order->name) }}</span>
                                @endif
                                <span class="tx-rubik mg-l-auto">
                                    @isset($_GET['filter'])
                                        @if($_GET['filter'] == 'sales')
                                            ₱ {{ number_format($order->filtered_value,2) }}
                                        @else
                                            {{ number_format($order->filtered_value,0) }}
                                        @endif
                                    @else
                                        ₱ {{ number_format($order->filtered_value,2) }}
                                    @endif
                                </span>
                            </div>

                            @endforeach
                            <input type="hidden" id="per_cat_colors" value="{{ $cat_colors }}">
                            <input type="hidden" id="per_cat_labels" value="{{ $cat_labels }}">
                            <input type="hidden" id="per_cat_revenues" value="{{ $cat_values }}">
                            <input type="hidden" id="total_cat_revenues" value="{{ $total_cat_sales }}">
                        </div>
                </div>
                <div class="card-footer text-center tx-13">
                    <a href="{{ route('admin.report.sales_category') }}?startdate={{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}&enddate={{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}" target="_blank" class="link-03">View All Categories <i class="icon ion-md-arrow-forward mg-l-5"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<div class="modal fade" id="modalBillingInfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered wd-sm-650" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </a>
                <div class="media align-items-center">
                    <div class="media-body">
                        <h4 class="tx-18 tx-sm-20 mg-b-2">Custom Date Range</h4>
                    </div>
                </div>
            </div>
            <form autocomplete="off" method="get" action="">
                <div class="modal-body pd-sm-t-30 pd-sm-x-30">
                    <div class="form-group">
                        <div data-label="Example" class="df-example demo-forms">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="data_from" value="custom_date">
                                    <input type="text" required id="dateFrom" name="startdate" class="form-control" placeholder="From">
                                </div>
                                <div class="col-6">
                                    <input type="text" required id="dateTo" name="enddate" class="form-control" placeholder="To">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pd-x-20 pd-y-15">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
<script src="{{ asset('lib/nestable2/jquery.nestable.min.js') }}"></script>
<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>

<script src="{{ asset('lib/chart.js/Chart.bundle.min.js') }}"></script>

<script>
    var dateFormat = 'yy-mm-dd',
    from = $('#dateFrom').datepicker({
        defaultDate: '+1w',
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd'
    }).on('change', function() {
        to.datepicker('option','minDate', getDate( this ) );
    }),
    to = $('#dateTo').datepicker({
        defaultDate: '+1w',
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd'
    }).on('change', function() {
        from.datepicker('option','maxDate', getDate( this ) );
    });

    function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }

        return date;
    }
</script>

<script>

    // line chart sales per month
        var months = $('#line_months').val();
        var sp_months = months.split('|');
        var arr_months = [];
        $.each(sp_months, function(key, value) {
            if(value != ""){
                arr_months.push(value);
            }
        });

        var yr1_total_sales = $('#yr1').val();
        var yr1_sales = yr1_total_sales.split(',');
        var arr_yr1_sales = [];
        $.each(yr1_sales, function(key, value) {
            if(value != ''){
                arr_yr1_sales.push(parseFloat(value));
            }
        });

        var yr2_total_sales = $('#yr2').val();
        var yr2_sales = yr2_total_sales.split(',');
        var arr_yr2_sales = [];
        $.each(yr2_sales, function(key, value) {
             if(value != ''){
                arr_yr2_sales.push(parseFloat(value));
            }
        });

        var yr3_total_sales = $('#yr3').val();
        var yr3_sales = yr3_total_sales.split(',');
        var arr_yr3_sales = [];
        $.each(yr3_sales, function(key, value) {
             if(value != ''){
                arr_yr3_sales.push(parseFloat(value));
            }
        });

        var yrs = $('#arr_yrs').val();
        var arr_yr = yrs.split('|');

        var ctx4 = document.getElementById('chartLine1');
        new Chart(ctx4, {
            type: 'line',
            data: {
                labels: arr_months,
                datasets: [{
                    data: arr_yr1_sales,
                    borderColor: '#00CCCC',
                    borderWidth: 3,
                    fill: false,
                    label: arr_yr[0],
                },{
                    data: arr_yr2_sales,
                    borderColor: '#007BFF',
                    borderWidth: 3,
                    fill: false,
                    label: arr_yr[1],
                },{
                    data: arr_yr3_sales,
                    borderColor: '#74DE00',
                    borderWidth: 3,
                    fill: false,
                    label: arr_yr[2],
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    labels: {
                        display: false
                    }
                },
                title: {
                    display: true,
                    text: 'Total Sales per Month (₱)'
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#e5e9f2'
                        },
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10,
                            max: 5000000
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            beginAtZero:true,
                            fontSize: 11
                        }
                    }]
                }
            },
        });
    //


    // pie chart sales by category
        var cat_colors = $('#per_cat_colors').val();
        var ccolors = cat_colors.split('|');
        var arr_ccolors = [];
        $.each(ccolors, function(key, value) {
            if(value != ""){
                arr_ccolors.push(value);
            }
        });

        var cat_labels = $('#per_cat_labels').val();
        var clabels = cat_labels.split('|');
        var arr_clabels = [];
        $.each(clabels, function(key, value) {
            if(value != ""){
                arr_clabels.push(value);
            }
        });

        var ctotal_revenues = parseFloat($('#total_cat_revenues').val());
        var cat_revenues = $('#per_cat_revenues').val();
        var crevenues = cat_revenues.split('|');
        var arr_cat_percent_revenues = [];
        $.each(crevenues, function(key, value) {
            if(value != ""){
                percnt = (parseFloat(value)/ctotal_revenues)*100;
                arr_cat_percent_revenues.push(percnt.toFixed(2));
            }
        });

        var datapie2 = {
            datasets: [{
                labels: arr_clabels,
                data: arr_cat_percent_revenues,
                backgroundColor: arr_ccolors
            }]
        };

        var optionpie2 = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            title: {
                display: true,
                text: "{{ $pie_ctgory_title }}"
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];        
                        return ' '+dataset.labels[tooltipItem.index]+': '+dataset.data[tooltipItem.index] + "%";
                    }
                }
            }
        };

        var ctxCategory = document.getElementById('chartCategory');
        var myDonutChart = new Chart(ctxCategory, {
            type: 'pie',
            data: datapie2,
            options: optionpie2
        });
    //



    // bar chart top products
        var top_prod_names = $('#top_prod_names').val();
        var prod_names = top_prod_names.split('|');
        var arr_prod_names = [];
        $.each(prod_names, function(key, value) {
            if(value != ""){
                arr_prod_names.push(value);
            }
        });

        var top_prod_earnings = $('#top_prod_earnings').val();
        var prod_earnings = top_prod_earnings.split('|');
        var arr_prod_earnings = [];
        $.each(prod_earnings, function(key, value) {
            if(value != ""){
                arr_prod_earnings.push(value);
            }
        });

        var ctx1 = document.getElementById('chartBar1').getContext('2d');

        var gradient1 = ctx1.createLinearGradient(0, 350, 0, 0);
        gradient1.addColorStop(0, '#001737');
        gradient1.addColorStop(1, '#0168fa');

        var gradient2 = ctx1.createLinearGradient(0, 400, 0, 0);
        gradient2.addColorStop(0, '#0168fa');
        gradient2.addColorStop(1, '#1ce1ac');
        
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: arr_prod_names,
                datasets: [{
                    data: arr_prod_earnings,
                    backgroundColor: gradient2
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false,
                    labels: {
                        display: false
                    }
                },
                title: {
                    display: true,
                    text: 'Top 10 Most Saleable Products'
                },
                scales: {
                    pointLabelFontSize : 10,
                    yAxes: [{
                        gridLines: {
                        color: '#e5e9f2'
                    },
                    ticks: {
                        beginAtZero:true,
                        fontSize: 10,
                        fontColor: '#182b49',
                    }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        barPercentage: 0.6,
                        ticks: {
                            beginAtZero:false,
                            fontSize: 11,
                            fontColor: '#182b49',
                            callback: function(label) {
                              if (/\s/.test(label)) {
                                return label.split("(");
                              }else{
                                return label;
                              }              
                            }
                        }
                    }]
                }
            }
        });
    //



    // pie chart social media
        var channel_colors = $('#per_channel_colors').val();
        var ch_colors = channel_colors.split('|');
        var arr_ch_colors = [];
        $.each(ch_colors, function(key, value) {
            if(value != ""){
                arr_ch_colors.push(value);
            }
        });

        var channel_labels = $('#per_channel_labels').val();
        var ch_labels = channel_labels.split('|');
        var arr_ch_labels = [];
        $.each(ch_labels, function(key, value) {
            if(value != ""){
                arr_ch_labels.push(value);
            }
        });

        var ch_total_revenues = parseFloat($('#total_channel_revenues').val());
        var channel_revenues = $('#per_channel_revenues').val();
        var ch_revenues = channel_revenues.split('|');
        var arr_ch_percent_revenues = [];
        $.each(ch_revenues, function(key, value) {
            if(value != ""){
                percnt = (parseFloat(value)/ch_total_revenues)*100;
                arr_ch_percent_revenues.push(percnt.toFixed(2));
            }
        });

        var datapie = {
            datasets: [{
                labels: arr_ch_labels,
                data: arr_ch_percent_revenues,
                backgroundColor: arr_ch_colors
            }]
        };

        var optionpie = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            title: {
                display: true,
                text: "{{ $pie_socmed_title }}"
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];        
                        return ' '+dataset.labels[tooltipItem.index]+': '+dataset.data[tooltipItem.index] + "%";
                    }
                }
            }
        };

        var ctx9 = document.getElementById('chartDonut');
        var myDonutChart = new Chart(ctx9, {
            type: 'pie',
            data: datapie,
            options: optionpie
        });
    //
</script>
@endsection
