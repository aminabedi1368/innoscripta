@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\ProjectModel::query()->count() }}</h3>

                    <p>Number of Projects</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.project.list_projects') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\UserModel::query()->count() }}</h3>

                    <p>Number of Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('admin.user.list_users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\AccessTokenModel::query()->count() }}</h3>

                    <p>Number of logins</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\BadLoginModel::query()->count() }}</h3>

                    <p>Bad Logins</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('admin.bad_logins.list_bad_logins') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>


    <div class="row mt-5">
        <div class="col-12">
            <h3>Report Registrations Monthly</h3>
            <canvas id="report_registration_monthly" width="400" height="100"></canvas>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3>Report Registrations Weekly</h3>
            <canvas id="report_registration_weekly" width="400" height="100"></canvas>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3>Report Registrations Daily</h3>
            <canvas id="report_registration_daily" width="400" height="100"></canvas>
        </div>
    </div>
@stop



@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/font-awesome.min.css">
@stop

@section('js')
    <script type="text/javascript" src="/vendor/adminlte/dist/js/chart.min.js"></script>

    <script type="text/javascript">

        const report_monthly = {!! json_encode($report_monthly) !!};
        const report_weekly = {!! json_encode($report_weekly) !!};
        const report_daily = {!! json_encode($report_daily) !!};

        const monthly_labels = report_monthly.map(item => item.year_month);
        const monthly_values = report_monthly.map(item => item.total);

        const weekly_labels = report_weekly.map(item => item.year_week);
        const weekly_values = report_weekly.map(item => item.total);

        const daily_labels = report_daily.map(item => item.year_month_day);
        const daily_values = report_daily.map(item => item.total);

        const ctx = document.getElementById('report_registration_monthly').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthly_labels,
                datasets: [{
                    label: '# of registration monthly',
                    data: monthly_values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        const ctx_week = document.getElementById('report_registration_weekly').getContext('2d');
        const myChart_week = new Chart(ctx_week, {
            type: 'bar',
            data: {
                labels: weekly_labels,
                datasets: [{
                    label: '# of registration weekly',
                    data: weekly_values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        const ctx_day = document.getElementById('report_registration_daily').getContext('2d');
        const myChart_day = new Chart(ctx_day, {
            type: 'bar',
            data: {
                labels: daily_labels,
                datasets: [{
                    label: '# of registration daily',
                    data: daily_values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>

@stop
