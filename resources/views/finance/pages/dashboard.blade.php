@php use App\Classes\Enums\UserTypesEnum; @endphp
@extends('admin.admin.app')
@section('pageTitle')
@endsection
@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas{
            width:600px !important;
            height:600px !important;
        }
    </style>
@endsection
@section('content')

    <div class="card-header pt-5">

        <h3 class="card-title">
            <span class="card-label fw-bolder fs-3 mb-1">Dashboard</span>
        </h3>
    </div>

    <div class="d-flex align-items-center w-100 mb-4">
        <canvas id="departmentChart" class="w-50 h-100"></canvas>
        <canvas id="typeOfExpanseChart" class="w-50 h-100" ></canvas>
    </div>
    <canvas id="yearChart" class="w-100" width="400" height="400"></canvas>

@endsection
@section('script')
    <script>
        var ctx = document.getElementById('departmentChart').getContext('2d');
        var departmentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {!! json_encode($departmentChart) !!},
            options: {
                // responsive: true,

                // maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Department Paid for Month of {{date('F')}}',
                        font: {
                            size: 50,
                            weight: 'bold'
                        }
                    },
                }
            }
        });


        var ctxtoe = document.getElementById('typeOfExpanseChart').getContext('2d');
        var typeOfExpanseChart = new Chart(ctxtoe, {
            type: 'doughnut',
            data: {!! json_encode($typeOfExpanseChart) !!},
            options: {
                // responsive: true,

                // maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Type Of Expanse for Month of {{date('F')}}',
                        font: {
                            size: 50,
                            weight: 'bold'
                        }
                    },
                }
            }
        });

        var ctxyear = document.getElementById('yearChart').getContext('2d');
        var yearChart = new Chart(ctxyear, {
            type: 'bar',
            data: {!! json_encode($yearChart) !!},
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: '{{date('Y')}} Expanse',
                    }
                }
            },
        });


    </script>

@endsection
