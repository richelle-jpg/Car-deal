@extends('layouts.container')

@section('title', 'Dashboard')

@section('m-content')

    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="display-4 font-monospace text-warning fw-bold">
                <i class="fas fa-car-side"></i> Car Dashboard <i class="fas fa-car-side"></i>
            </h1>
            
        </div>
    </div>

    <!-- Charts Layout -->
    <div class="row">
        <!-- Total Cars (Bar Chart) -->
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card bg-dark text-light shadow-lg rounded border border-warning">
                <div class="card-body">
                    <div class="card-header font-monospace fs-3 text-warning px-0">
                        Total Cars
                    </div>
                    <canvas id="totalCarsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Total Car Value (Line Chart) -->
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card bg-dark text-light shadow-lg rounded border border-success">
                <div class="card-body">
                    <div class="card-header font-monospace fs-3 text-success px-0">
                        Total Car Value
                    </div>
                    <canvas id="totalCarValueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Best-Selling Car Types (Bar Chart) -->
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card bg-dark text-light shadow-lg rounded border border-danger">
                <div class="card-body">
                    <div class="card-header font-monospace fs-3 text-danger px-0">
                        Best-Selling Car Types
                    </div>
                    <canvas id="bestSellingCarChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 mb-4">
            <div class="card bg-dark text-light shadow-lg rounded border border-danger">
                <div class="card-body">
                    <div class="card-header font-monospace fs-3 text-danger px-0">
                        Orders Overview
                    </div>
                    <div id="ordersPieChartContainer"> <!-- Add container -->
                        <canvas id="ordersPieChart"></canvas>
                    </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        body {
            background: #121212;
        }
        .card:hover {
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }
        .card {
            border-radius: 15px;
        }
        #ordersPieChartContainer {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 320px; /* Adjust height to align with bar chart */
}

    </style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Bar Chart for Total Cars
    var totalCarsCtx = document.getElementById("totalCarsChart").getContext("2d");
    new Chart(totalCarsCtx, {
        type: "bar",
        data: {
            labels: ["Total Cars"],
            datasets: [{
                label: "Total Cars",
                data: [@json($carsCount)],
                backgroundColor: "rgba(54, 162, 235, 0.2)", // Softer transparent blue
            borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Line Chart for Total Car Value
    var totalCarValueCtx = document.getElementById("totalCarValueChart").getContext("2d");
    new Chart(totalCarValueCtx, {
        type: "line",
        data: {
            labels: ["Total Car Value"],
            datasets: [{
                label: "Total Car Value",
                data: [@json($sumCarPrise)],
                backgroundColor: "rgba(75, 192, 75, 0.2)", // Softer transparent green
                borderColor: "rgba(75, 192, 75, 1)",
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return "₱" + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Bar Chart for Best-Selling Car Types
    var bestSellingCarCtx = document.getElementById("bestSellingCarChart").getContext("2d");
    new Chart(bestSellingCarCtx, {
    type: "bar",
    data: {
        labels: @json($carTypes),
        datasets: [{
            label: "Number of Sales",
            data: @json($carTypeCounts),
            backgroundColor: [
                "rgba(255, 99, 132, 0.3)",   // Light red
                "rgba(54, 162, 235, 0.3)",   // Light blue
                "rgba(255, 206, 86, 0.3)",   // Light yellow
                "rgba(75, 192, 192, 0.3)"    // Light teal
            ],
            borderColor: [
                "rgba(255, 99, 132, 1)",  // Dark red
                "rgba(54, 162, 235, 1)",  // Dark blue
                "rgba(255, 206, 86, 1)",  // Dark yellow
                "rgba(75, 192, 192, 1)"   // Dark teal
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});

   // Set a fixed height for the pie chart container
document.getElementById("ordersPieChart").parentNode.style.height = "300px";
var ordersPieCtx = document.getElementById("ordersPieChart").getContext("2d");
new Chart(ordersPieCtx, {
    type: "pie",
    data: {
        labels: ["Total Orders", "Incomplete Orders", "Completed Orders"],
        datasets: [{
            label: "Orders Overview",
            data: [
                @json($OraderTotalSum->count()), 
                @json($OraderIncompleteSum->count()), 
                @json($OraderTotalSum->count() - $OraderIncompleteSum->count())
            ],
            backgroundColor: [
                "rgba(255, 99, 132, 0.3)",  // Light Red
                "rgba(255, 206, 86, 0.3)",  // Light Yellow
                "rgba(54, 162, 235, 0.3)"   // Light Blue
            ],
            borderColor: [
                "rgba(255, 99, 132, 1)",  // Dark Red
                "rgba(255, 206, 86, 1)",  // Dark Yellow
                "rgba(54, 162, 235, 1)"   // Dark Blue
            ],
            borderWidth: 3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Allow resizing
        layout: {
            padding: 10 // Add some space around the chart
        },
        plugins: {
            legend: { position: 'top' },
            tooltip: { enabled: true }
        }
    }
});

});

</script>
@endsection
