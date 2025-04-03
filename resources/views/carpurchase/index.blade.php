@extends('layouts.container')

@section('m-content')
<button id="darkModeToggle" class="btn btn-dark position-fixed top-0 end-0 m-3">🌙</button>
<div class="container mt-5">
    <h2 class="mb-4">Expenses Analytics</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('carpurchase.index') }}" class="list-group-item list-group-item-action active">
                    Car Purchase Tracking
                </a>
            </div>
        </div>

        <!-- Chart Display Only -->
        <div class="col-md-9">
            <div style="width: 100%; height: 350px;"> 
                <canvas id="expensesChart"></canvas>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode {
    background-color: #121212;
    color: #ffffff;
}
#darkModeToggle {
    position: fixed !important;
    top: 80px !important; /* Increase this value to move it further down */
    right: 20px !important; /* Adjust this if necessary */
    z-index: 1000 !important; /* Ensures it stays above other elements */
    background-color: #333;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.3s ease;
}

#darkModeToggle:hover {
    background-color: #444;
}


.dark-mode .card {
    background-color: #1e1e1e;
    color: #ffffff;
    border-color: #333;
}

.dark-mode input,
.dark-mode select,
.dark-mode textarea {
    background-color: #333;
    color: #fff;
    border-color: #555;
}

.dark-mode .btn {
    background-color: #444;
    color: #fff;
}

.dark-mode .btn-outline-secondary {
    background-color: transparent;
    color: #fff;
    border-color: #ccc;
}

</style>


<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script> 

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let purchaseData = {!! json_encode($purchaseData) !!};

        if (purchaseData.length === 0) {
            purchaseData = [{ date: moment().format('YYYY-MMM'), amount: 0 }];
        }

        console.log("Purchase Data:", purchaseData);

        const ctx = document.getElementById('expensesChart');

        if (ctx) {
            const data = {
                labels: purchaseData.map(item => item.date),
                datasets: [{
                    label: 'Total Spent (₱)',
                    data: purchaseData.map(item => item.amount),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar', 
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'category', 
                            title: {
                                display: true,
                                text: 'Timeline (Month & Year)',
                                font: { size: 14 }
                            },
                            ticks: {
                                font: { size: 12 },
                                maxRotation: 0,
                                minRotation: 0
                            },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Spent (₱)',
                                font: { size: 14 }
                            },
                            ticks: {
                                font: { size: 12 }
                            },
                            grid: {
                                color: "rgba(0, 0, 0, 0.1)"
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false 
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `₱${tooltipItem.raw.toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        } else {
            console.error("Canvas not found");
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeToggle = document.getElementById("darkModeToggle");
        const body = document.body;

        // Check user preference from localStorage
        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
        }

        darkModeToggle.addEventListener("click", function () {
            body.classList.toggle("dark-mode");

            // Save preference in localStorage
            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("darkMode", "enabled");
            } else {
                localStorage.setItem("darkMode", "disabled");
            }
        });
    });
</script>
@endsection
