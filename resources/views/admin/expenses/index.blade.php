@extends('admin.layouts.master')

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">{{ __('custom.expenses_list') }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">{{ __('custom.expenses') }}</a></li>
                <li class="breadcrumb-item active">{{ __('custom.expenses_list') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xl-8">
        <div class="card">
            <div class="card-body">
                <div class="row align-item-center">
                    <div class="col-lg-12 ic-expance-text-heading-part">
                        <h4 class="ic-expance-heading">{{ __('custom.expenses') }} @if(!request()->from_date) {{
                            __('custom.this_year') }} @endif
                        </h4>
                        <h3 class="ic-earning-heading">{{currencySymbol()}}{{make2decimal($total)}}</h3>
                    </div>
                    <div class="col-lg-8 my-auto ic-expance-form-heads">
                        <form action="">
                            <div class="row input-daterange ic-mobile-range">
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group mb-lg-0">
                                        <input type="text" name="from_date" value="{{ request()->from_date }}" id="from_date" class="form-control" placeholder="From Date" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-group mb-lg-0">
                                        <input type="text" name="to_date" value="{{ request()->to_date }}" id="to_date" class="form-control" placeholder="To Date" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 col-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="mdi mdi-filter"></i> {{ __('custom.filter') }}</button>
                                </div>
                                <div class="col-md-6 col-lg-3 col-12">
                                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-primary btn-block mt-3 mt-md-0">
                                        <i class="mdi mdi-refresh"></i> {{ __('custom.refresh') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 my-auto ic-expance-form-chart input-daterange ic-mobile-range">
                        <button class="btn btn-secondary" type="button" id='line'><i class="fas fa-chart-line"></i>
                            {{ __('custom.line') }}</button>
                        <button class="btn btn-secondary" type="button" id='bar'><i class="fas fa-chart-bar"></i>
                            {{ __('custom.bar') }}</button>
                    </div>
                </div>
                <canvas id="expensesChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-xl-4">
        <div class="card ic-max-height-same">
            <div class="card-body">
                <div class="ic-expance-part">
                    <div class="ic-expance-text">
                        <h4 class="ic-expance-heading">{{__('custom.expenses_all_time')}}</h4>
                        <h3 class="ic-earning-heading">{{currencySymbol()}}{{make2decimal($total_all_time)}}</h3>
                    </div>
                </div>
                <div class="ic-piechart-part">
                    <canvas id="pieChart"></canvas>
                    <ul>
                        <li><span class="this-mounth"><span class="circle-this"></span> {{__('custom.this_month')}}
                                {{currencySymbol()}}{{make2decimal($this_month_total)}}</span></li>
                        <li><span class="last-mounth"><span class="circle-last"></span> {{__('custom.last_month')}}
                                {{currencySymbol()}}{{make2decimal($last_month_total)}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">{{ __('custom.expenses') }}</h4>
                {!! $dataTable->table() !!}
            </div>
        </div>
    </div>
</div>


@endsection

@push('style')
@include('includes.styles.datatable')

@endpush

@push('script')
@include('includes.scripts.datatable')

<script type="text/javascript">
    !(function($) {
        "use strict"
        // chart js
        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const data = {
            labels: labels,
            datasets: [{
                label: '{{ __('custom.expenses') }}({{ currencySymbol() }})',
                backgroundColor: '#FF5733',
                borderColor: '#FF5733',
                data: @php echo json_encode($graph_data) @endphp,
            }]
        };

        // init config
        const config = {
            type: 'line',
            data,
            options: {}
        };

        let myChart;

        // chart js click change
        icChange('line');
        $("#line").on('click', function() {
            icChange('line');
        });
        $("#bar").on('click', function() {
            icChange('bar');
        });

        function icChange(newType) {
            let ctx = document.getElementById("expensesChart").getContext("2d");

            if (myChart) {
                myChart.destroy();
            }

            let temp = jQuery.extend(true, {}, config);
            temp.type = newType;
            myChart = new Chart(ctx, temp);
        };

        // Peity line
        $('.peity-line').each(function() {
            $(this).peity("line", $(this).data());
        });
        // pie chart
        let oilCanvas = document.getElementById("pieChart");
        let oilData = {
            datasets: [{
                data: @php echo json_encode($pie_graph_data) @endphp,
                backgroundColor: [
                    "#FF6384",
                    "#63FF84",
                    "#6FE3D5",
                    "#5182FF",
                    "#56C876",
                    "#2A73A8",
                    "#EEBF48",
                    "#6FE3C0",
                    "#28AAA9",
                    "#6FE3C0",
                    "#3D96FF",
                    "#E36F6F"
                ]
            }]
        };
        // pie chart
        let pieChart = new Chart(oilCanvas, {
            type: 'pie',
            data: oilData,
            options: {
                responsive: true,
                legend: {
                    display: true,
                    position: 'bottom'
                },
            },
        });

    })(jQuery)
</script>
@endpush
