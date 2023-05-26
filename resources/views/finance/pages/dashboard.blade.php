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

    <div class="card-header pt-5">
{{--@dd($yearChart)--}}
        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Dashboard</span>
        </h3>
    
        <button class="btn btn-info" id="changepass" data-toggle="modal" data-target="#changemodal" data-id="{{$user_id}}">Change Password</button>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="changemodal" >
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form method="post" action="{{route(auth()->user()->user_type . '.changepassword')}}">
                    @csrf
                    <div class="modal-header" style="text-align: center;">
                        <h2 class="modal-title" id="myModalLabel">Change Password</h2>
                    </div>
                    <div class="modal-body" style="text-align: center;">

                     
                        <input type="hidden" name="id" class="user-delete" value="<?php echo $user_id; ?>"/>
                        <label>Current Password </label>
                <input type="password" name="currentPassword" class="form-control" required>
                <label>New Password </label>
                <input type="password" name="password"  class="form-control" required>
                <label>Confirm New Password</label>
                <input type="password" name="passwordConfirm"  class="form-control" required>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center w-100 mb-4">
        <canvas id="departmentChart" class="w-50 h-100"></canvas>
        <canvas id="typeOfExpanseChart" class="w-50 h-100" ></canvas>
    </div>
    <div class="outbox">
        <div class="container">
    <canvas id="yearChart" width="400" height="400"></canvas>
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
                            size: 30
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
                            size: 30
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
            //         }
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
                            size: 30
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


    </script>

@endsection
