@extends('layouts.header')
@if(isset($data)) @section("title","Dashboard")  @else @section("title","Dashboard") @endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!--            <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>5</h3>
            
                                    <p>Total email sent</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>-->
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $allapplication }}</h3>

                        <p>Total Application</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-wpforms"></i>
                    </div>
                    <a href="{{ url('admin/application/all') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $unreadapplication }}</h3>

                        <p>Unread Application</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <a href="{{ url('admin/application/unread') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $today_client_application }}</h3>

                        <p>Today's Application</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <a href="{{ url('admin/application/today') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $totalmobile }}</h3>

                        <p>Total Mobile Application</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-mobile"></i>
                    </div>
                    <a href="{{ url('admin/application/mobile') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $totalweb }}</h3>

                        <p>Total Web Application</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-laptop"></i>
                    </div>
                    <a href="{{ url('admin/application/web') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Summary</h3>
                                <div id="msg"></div>
                                <div class="col-md-9 form">
                                    <form id="search_frm" class="form-inline" style="padding: 10px 0 10px 0;" method="post">
                                        <div class="form-group">
                                            <label>Start Date :</label>
                                            <input type="text" id="start_date" name="start_date" class="start_date time form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label>End Date :</label>
                                            <input type="text" id="end_date" name="end_date" class="end_date time form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="button" class="filter_btn btn btn-sm btn-primary" value="Filter">
                                            <input type="reset" class="reset_btn btn btn-sm btn-primary" value="Reset">
                                        </div>
                                    </form>
                                </div>
                                <div id="filterdata" class="col-md-3" style="padding: 10px 0 10px 0;" >
                                    <li class="today">
                                        <a class="highchart btn btn-sm btn-primary" onclick="Highchart('today')">Today</a>
                                    </li>
                                    <li class="week active">
                                        <a class="highchart btn btn-sm btn-primary" onclick="Highchart('week')">Week</a>
                                    </li>
                                    <li class="month">
                                        <a class="highchart btn btn-sm btn-primary" onclick="Highchart('month')">Month</a>
                                    </li>
                                </div>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">

    $(document).ready(function () {
        var $navLIs = $('#filterdata li');
        $navLIs.find('a').click(function () {
            $navLIs.removeClass('active');
            $(this).parent().addClass('active');
        });
//           $.datepicker.setDefaults({
//
//        changeMonth: true,
//
//        changeYear: true,
//
//        dateFormat: 'dd/mm/yy'});
//    $('.start_date').datepicker({
//        minDate: '+0',
//        onSelect: function(dateStr) {
//            var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
//            var max = new Date(min.getTime());
//            max.setMonth(max.getMonth() + 1); // Add one month
//            $('.end_date').datepicker('option', {minDate: min, maxDate: max});
//        }
//    });
//    $('.end_date').datepicker({
//        minDate: '+0',
//
//        maxDate: '+1m',
//
//        onSelect: function(dateStr) {
//
//            var max = $(this).datepicker('getDate'); // Selected date or null if none
//            $('.start_date').datepicker('option', {maxDate: max});
//
//        }
//
//    });
        var today = new Date();
        $("#start_date").datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            endDate: "today",
            maxDate: today
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            minDate.setDate(minDate.getDate());

            $('#end_date').datepicker('setStartDate', minDate);
            $('#end_date').datepicker('setEndDate', today);
            $('#end_date').datepicker('dateFormat', 'yy-mm-dd');
        });
    });
</script>
<script>
    $('#filterdata').on('click', '.highchart', function () {
        $('#search_frm').trigger("reset");
    });
    $('#filterdata').on('click', 'li', function () {
        $('#filterdata li.active').removeClass('active');
        $(this).addClass('active');
    });
    $("body").on('click', '.reset_btn', function () {
        $('#search_frm').trigger("reset");
        $('#filterdata li.active').removeClass('active');
        $('#filterdata li.week').addClass('active');
        Highchart();
    });
    $("body").on('click', '.filter_btn', function () {
        $('#filterdata li.active').removeClass('active');
        var startdate = $('.start_date').val();
        var end_date = $('.end_date').val();
        if (startdate === '' && end_date === '') {
            alert('Select both date');
            return false;
        }
        if (startdate === '') {
            alert('Select first date');
            return false;
        }
        if (end_date === '') {
            alert('Select end date');
            return false;
        }
        if (startdate !== '' && end_date !== '') {
            Highchart();
        }
    });
    $(document).ready(function () {
        Highchart();
    });
    /**
     * Highchart
     */
    function Highchart(charttype = "week") {
      
        $.ajax({
            type: "POST",
            url: '{{"chart_details"}}',
            data: $("#search_frm").serialize() + "&charttype=" + charttype,
            'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (data) {
                if (data.month != '' && data.greycount != '' && data.greencount != '') {
                    var text = 'Application Summary';
                }
                else {
                    text = 'No application matched your search. Try using search with different.'
                }
                if (data) {
                    Highcharts.chart('container', {
                        credits: {
                            enabled: false
                        },
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: text
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            categories: data.month,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Applications'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:f}</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                name: 'Mobile',
                                color: '#00c0ef',
                                data: data.greycount

                            }, {
                                name: 'Web',
                                color: '#008000',
                                data: data.greencount
                            }
                            , {
                                name: 'Unread',
                                color: '#f39c12',
                                data: data.unread
                            }
                        ]
                    });
                }
            }
            // },
            // error: function(jqXHR, textStatus, errorThrown){
            //     alert(errorThrown +' '+ textStatus)

            // }
        });
    }
</script>
@endsection