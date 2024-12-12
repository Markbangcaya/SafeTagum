<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <!-- <li class="breadcrumb-item active">Starter Page</li> -->
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">CPU Traffic</span>
                                <span class="info-box-number">
                                    10
                                    <small>%</small>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-thumbs-up"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Likes</span>
                                <span class="info-box-number">41,410</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="clearfix hidden-xs-up"></div> -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i
                                    class="fas fa-shopping-cart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Sales</span>
                                <span class="info-box-number">760</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">New Cases</span>
                                <span class="info-box-number">2,000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Yearly Trend</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- <div class="col-10"> -->
                                    <div class="chart-responsive">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <line-chart id="my-chart-id" :options="options" :data="barData" />
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                    <!-- <div class="col-2">
                                        <ul class="chart-legend clearfix">
                                            <li><i class="far fa-circle text-danger"></i> Chrome</li>
                                            <li><i class="far fa-circle text-success"></i> IE</li>
                                            <li><i class="far fa-circle text-warning"></i> FireFox</li>
                                            <li><i class="far fa-circle text-info"></i> Safari</li>
                                            <li><i class="far fa-circle text-primary"></i> Opera</li>
                                            <li><i class="far fa-circle text-secondary"></i> Navigator</li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            United States of America
                                            <span class="float-right text-danger">
                                                <i class="fas fa-arrow-down text-sm"></i>
                                                12%</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            India
                                            <span class="float-right text-success">
                                                <i class="fas fa-arrow-up text-sm"></i> 4%
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            China
                                            <span class="float-right text-warning">
                                                <i class="fas fa-arrow-left text-sm"></i> 0%
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Monthly Trend</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- <div class="col-10"> -->
                                    <div class="chart-responsive">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <Doughnut id="my-chart-id" :options="options" :data="barData" />
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                    <!-- <div class="col-2">
                                        <ul class="chart-legend clearfix">
                                            <li><i class="far fa-circle text-danger"></i> Chrome</li>
                                            <li><i class="far fa-circle text-success"></i> IE</li>
                                            <li><i class="far fa-circle text-warning"></i> FireFox</li>
                                            <li><i class="far fa-circle text-info"></i> Safari</li>
                                            <li><i class="far fa-circle text-primary"></i> Opera</li>
                                            <li><i class="far fa-circle text-secondary"></i> Navigator</li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            United States of America
                                            <span class="float-right text-danger">
                                                <i class="fas fa-arrow-down text-sm"></i>
                                                12%</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            India
                                            <span class="float-right text-success">
                                                <i class="fas fa-arrow-up text-sm"></i> 4%
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            China
                                            <span class="float-right text-warning">
                                                <i class="fas fa-arrow-left text-sm"></i> 0%
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: false,
                        text: 'Reported HFMD Cases and Case Fatality Rate by BARANGAY in TAGUM  CITY, MW 1 – 32, (n = 32)',
                        font: {
                            size: 16
                        },
                        padding: {
                            top: 20,
                            bottom: 20
                        }
                    },
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        display: true,
                        title: {
                            display: true,
                            text: 'Barangay',
                            position: 'bottom'
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        suggestedMax: 20
                    },
                },
                tension: 0.1
            },
            barData: {
                labels: ['APOKON', 'BUSAON', 'CANOCOTAN', 'CUAMBOGAN', 'LA FILIPINA', 'MADAUM', 'MAGDUM'],
                datasets: [
                    {
                        label: '0-5 Years Old',
                        data: [30, 40, 50, 60, 30, 40, 50, 60, 30, 40, 50, 60],
                        backgroundColor: 'rgb(49,212,246)',
                        borderColor: 'rgb(12,204,244)',
                        borderWidth: 1

                    },
                    {
                        label: '6-10 Years Old',
                        data: [30, 40, 50, 60, 30, 40, 50, 60, 30, 40, 50, 60],
                        backgroundColor: 'rgb(24,124,256)',
                        borderColor: 'rgb(12,108,252)',
                        borderWidth: 1
                    },
                    {
                        label: '11-15 Years Old',
                        data: [20, 34, 54, 66, 30, 40, 50, 60, 30, 40, 50, 60],
                        backgroundColor: 'rgba(234, 179, 8, .3)',
                        borderColor: 'rgb(234, 179, 8)',
                        borderWidth: 1
                    },
                    {
                        label: '16 And Above Years Old',
                        data: [69, 69, 69, 69, 96, 99, 96, 69, 69, 44, 20, 11],
                        backgroundColor: 'rgb(112,116,124)',
                        borderColor: 'rgb(112,116,124)',
                        borderWidth: 1
                    },
                    {
                        label: 'Death',
                        data: [15, 25, 35, 45, 55, 65, 75, 85, 95, 69, 54, 20],
                        backgroundColor: 'rgba(239, 68, 68, .3)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1
                    },
                    {
                        label: 'Grand Total of Cases',
                        data: [30, 40, 50, 60, 30, 40, 50, 60, 30, 40, 50, 60],
                        backgroundColor: 'rgba(34, 197, 94, .3)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1
                    },
                    // {
                    //     label: 'Total',
                    //     data: sumData,//props.monthlyVendorDetectionsBarChartData.data,
                    //     backgroundColor: 'rgba(168, 85, 247, .3)',
                    //     borderColor: 'rgb(168, 85, 247)',
                    //     stack: 'combined',
                    //     type: 'line',
                    //     pointRadius: 10,
                    //     pointHitRadius: 12
                    // }
                ]
            }
        }
    },
    mounted() {

    }
}
</script>
