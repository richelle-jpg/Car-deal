@extends('layouts.container_agent')

@section('title')
    Dashboard
@endsection

@section('m-content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-3 fw-bold text-light">🚗 Car Dealership Dashboard</h1>
            </div>
        </div>

        <!-- Car Stats -->
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card car-card shadow-lg">
                    <div class="card-body">
                        <h4 class="card-header text-info fw-bold">Total Cars Available</h4>
                        <div class="card-content d-flex align-items-center justify-content-between">
                            <i class="fa-solid fa-car fs-1 text-info"></i>
                            <span class="fs-1 fw-bold text-info">{{ $carsCount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card car-card shadow-lg">
                    <div class="card-body">
                        <h4 class="card-header text-warning fw-bold">Total Car Value</h4>
                        <div class="card-content d-flex align-items-center justify-content-between">
                            <i class="fa-solid fa-coins fs-1 text-warning"></i>
                            <span class="fs-1 fw-bold text-warning">{{ $sumCarPrise }} ₱</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Order Stats -->
         <div class="row mt-4">
            <div class="col-12 text-center">
                <h1 class="order-overview-title fw-bold text-light">📦 Orders Overview</h1>
            </div>
        </div>
        

        <div class="row mt-3">
            <div class="col-md-4 mb-4">
                <div class="card order-card shadow-lg">
                    <div class="card-body">
                        <h4 class="card-header text-primary fw-bold">Total Orders</h4>
                        <div class="card-content d-flex align-items-center justify-content-between">
                            <i class="fa-solid fa-shopping-cart fs-1 text-primary"></i>
                            <span class="fs-1 fw-bold text-primary">{{ $OraderTotalSum->count() }}</span>
                        </div>
                        <h3 class="text-primary fw-semibold">{{ $OraderTotalSum->sum('price') }} ₱</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card order-card shadow-lg">
                    <div class="card-body">
                        <h4 class="card-header text-danger fw-bold">Incomplete Orders</h4>
                        <div class="card-content d-flex align-items-center justify-content-between">
                            <i class="fa-solid fa-exclamation-triangle fs-1 text-danger"></i>
                            <span class="fs-1 fw-bold text-danger">{{ $OraderIncompleteSum->count() }}</span>
                        </div>
                        <h3 class="text-danger fw-semibold">{{ $OraderIncompleteSum->sum('price') }} ₱</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card order-card shadow-lg">
                    <div class="card-body">
                        <h4 class="card-header text-success fw-bold">Completed Orders</h4>
                        <div class="card-content d-flex align-items-center justify-content-between">
                            <i class="fa-solid fa-check-circle fs-1 text-success"></i>
                            <span class="fs-1 fw-bold text-success">
                                {{ $OraderTotalSum->count() - $OraderIncompleteSum->count() }}
                            </span>
                        </div>
                        <h3 class="text-success fw-semibold">
                            {{ $OraderTotalSum->sum('price') - $OraderIncompleteSum->sum('price') }} ₱
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-12 text-center mb-4">
        <h1 class="display-1 font-monospace text-primary fw-bold">📦 Analytics 📦</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card bg-dark text-light shadow-lg rounded border border-primary">
            <div class="card-body">
                <div class="card-header font-monospace fs-3 text-primary px-0">
                    Total Orders
                </div>
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card bg-dark text-light shadow-lg rounded border border-danger">
            <div class="card-body">
                <div class="card-header font-monospace fs-3 text-danger px-0">
                    Incomplete Orders
                </div>
                <canvas id="incompleteOrdersChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card bg-dark text-light shadow-lg rounded border border-success">
            <div class="card-body">
                <div class="card-header font-monospace fs-3 text-success px-0">
                    Completed Orders
                </div>
                <canvas id="completedOrdersChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <style>
         body {
            background-color: #121212; /* Dark mode */
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .car-card, .order-card {
            background: linear-gradient(135deg, #1c1c1c, #2d2d2d);
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
            padding: 15px;
        }

        .car-card:hover, .order-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 16px rgba(255, 0, 0, 0.4);
        }

        .card-header {
            font-size: 1rem;
            text-transform: uppercase;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 8px;
        }

        .card-content {
            margin-top: 10px;
        }

        /* Fixed smaller size for 📦 Orders Overview */
        .order-overview-title {
            font-size: 1.5rem; /* Proper smaller size */
            font-weight: 600;
            margin-top: 10px;
        }

        .fs-3 {
            font-size: 1.8rem !important; /* Smaller icon size */
        }
        
    </style>
@endsection

<script>
   document.addEventListener("DOMContentLoaded", function () {
    var ordersCtx = document.getElementById("ordersChart").getContext("2d");
    var incompleteCtx = document.getElementById("incompleteOrdersChart").getContext("2d");
    var completedCtx = document.getElementById("completedOrdersChart").getContext("2d");

    var ordersChart = new Chart(ordersCtx, {
        type: "line",
        data: {
            labels: @json($months),
            datasets: [{
                label: "Total Orders",
                data: @json($totals),
                backgroundColor: "rgba(54, 162, 235, 0.6)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    var incompleteChart = new Chart(incompleteCtx, {
        type: "line",
        data: {
            labels: @json($months),
            datasets: [{
                label: "Incomplete Orders",
                data: @json($incompleteTotals),
                backgroundColor: "rgba(255, 99, 132, 0.6)",
                borderColor: "rgba(255, 99, 132, 1)",
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    var completedChart = new Chart(completedCtx, {
        type: "line",
        data: {
            labels: @json($months),
            datasets: [{
                label: "Completed Orders",
                data: @json($completedTotals),
                backgroundColor: "rgba(75, 192, 75, 0.6)",
                borderColor: "rgba(75, 192, 75, 1)",
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
});

</script>
