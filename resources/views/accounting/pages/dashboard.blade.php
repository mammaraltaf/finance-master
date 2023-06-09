@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <style>
        canvas{
            width:600px !important;
            height:600px !important;
        }
        .outbox{
            text-align: center;
        }
        .container{
            width: 50%;
            display: inline-block;
        }
    </style> --}}
@endsection
@section('content')
    <!--begin::Header-->
    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Dashboard</span>
        </h3>
    </div>
    <div class="d-flex align-items-center w-100 mb-4">
        <canvas id="departmentChart" class="w-50 h-100"></canvas>
        <canvas id="typeOfExpanseChart" class="w-50 h-100" ></canvas>
    </div>
    <div class="outbox">
        <div class="container">
            <canvas class="w-25 h-25" id="yearChart" width="400" height="400"></canvas>
        </div>
    </div>


@endsection
@section('script')
    <script>
        var ctx = document.getElementById('departmentChart').getContext('2d');
        var departmentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {!! json_encode($departmentChart) !!},
            // options: {
            //     // responsive: true,

            //     // maintainAspectRatio: false,
            //     plugins: {
            //         legend: {
            //             position: 'top',
            //         },
            //         title: {
            //             display: true,
            //             text: 'Department Paid for Month of {{date('F')}}',
            //             font: {
            //                 size: 50,
            //                 weight: 'bold'
            //             }
            //         },
            //     }
            // }
            options: {

                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.formattedValue;
                            }
                        }, titleFont: {
                                size: 30
                            },
                            bodyFont: {
                            size: 30
                        },
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 20
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Department Paid for Month of {{date('F')}}',
                        font: {
                            size: function(context) {
                                var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                                return screenWidth < 600 ? 16 : 30;
                            }
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            font: {
                                size: 50
                            }
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            font: {
                                size: 50
                            }
                        }
                    }]
                }
            }

        });


        var ctxtoe = document.getElementById('typeOfExpanseChart').getContext('2d');
        var typeOfExpanseChart = new Chart(ctxtoe, {
            type: 'doughnut',
            data: {!! json_encode($typeOfExpanseChart) !!},
            // options: {
            //     // responsive: true,

            //     // maintainAspectRatio: false,
            //     plugins: {
            //         legend: {
            //             position: 'top',
            //         },
            //         title: {
            //             display: true,
            //             text: 'Type Of Expanse for Month of {{date('F')}}',
            //             font: {
            //                 size: 50,
            //                 weight: 'bold'
            //             }
            //         },
            //     }
            // }
            options: {

                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.formattedValue;
                            }
                        },
                        titleFont: {
                                size: 30
                            },
                            bodyFont: {
                            size: 30
                        },

                    },
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 20
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Type Of Expense for Month of {{date('F')}}',
                        font: {
                            size: function(context) {
                                var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                                return screenWidth < 600 ? 16 : 30;
                            }
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            font: {
                                size: 20
                            }
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            font: {
                                size: 20
                            }
                        }
                    }]
                }
            }
        });

        var ctxyear = document.getElementById('yearChart').getContext('2d');
        var yearChart = new Chart(ctxyear, {
            type: 'bar',
            data: {!! json_encode($yearChart) !!},
            // options: {
            //     responsive: true,
            //     plugins: {
            //         legend: {
            //             position: 'top',
            //         },
            //         title: {
            //             display: true,
            //             text: '{{date('Y')}} Expanse',
            //         }y-2
            //     }
            // },
            options: {

                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return 'GEL: ' + context.formattedValue;
                            }
                        }, titleFont: {
                                size: 20
                            },
                            bodyFont: {
                            size: 20
                        },
                    },
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 20
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: '{{date('Y')}} Expense',
                        font: {
                            size: function(context) {
                                var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                                return screenWidth < 600 ? 16 : 30;
                            }
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            font: {
                                size: function(context) {
                                var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                                return screenWidth < 600 ? 12 : 30;
                            }
                            }
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            font: {
                                size: function(context) {
                                var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                                return screenWidth < 600 ? 12 : 30;
                            }
                            }
                        }
                    }]
                }
            }
        });


    </script>

@endsection
