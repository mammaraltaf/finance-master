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

    <canvas id="financeChart" width="400" height="400"></canvas>

@endsection
@section('script')
    <script>
        var ctx = document.getElementById('financeChart').getContext('2d');
        var financeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {!! json_encode($data) !!},
            options: {
                // responsive: true,

                // maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Finance Statistics',
                        font: {
                            size: 50,
                            weight: 'bold'
                        }
                    },
                }
            }
        });
    </script>

@endsection
