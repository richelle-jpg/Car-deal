@extends('layouts.appCustomer')

@section('title')
    Orders
@endsection

@section('m-content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1">
            <div class="row">
                <div class="col-md-12">
                    <!-- All Cars -->
                    <div class="card">
                        <h5 class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="text-primary">All Orders</h2>
                            </div>
                        </h5>
                        <div class="table-responsive text-nowrap">
                            <div id="carTableDiv">
                                <table class="table table-striped" id="CarTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Car</th>
                                            <th>Type</th>
                                            <th>Price</th>
                                            <th>Color</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    @if (count($orders) > 0)
                                        <tbody class="table-border-bottom-0">
                                            @php $count = 1; @endphp
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $order->carName }}</td>
                                                    <td>{{ $order->type }}</td>
                                                    <td>{{ $order->price }}</td>
                                                    <td>{{ $order->color }}</td>
                                                    <td>
                                                        @if ($order->status == 'complete')
                                                            <span class="badge rounded-pill bg-success">Complete</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-danger">Incomplete</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                            <div class="col-12 mt-3 text-center">
                                <div class="d-flex justify-content-center gap-3">
                                    <button type="button" class="btn btn-primary rounded-0" id="printOrders">
                                        <span class="tf-icons bx bx-printer"></span>&nbsp; Print
                                    </button>
                                    <button class="btn btn-dark rounded-0" id="darkModeToggle">Dark Mode</button>
                                </div>
                            </div>
                            
                        <div class="card-footer">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>
    <!-- Content wrapper -->
@endsection

@section('styles')
    <style>
        /* Default Light Theme */
:root {
    --background-color: #ffffff;
    --text-color: #333;
    --card-background: #f8f9fa;
    --table-background: #ffffff;
    --badge-bg-success: #28a745;
    --badge-bg-danger: #dc3545;
    --button-bg: #007bff;
    --button-text: #fff;
}

/* Improved Dark Theme */
.dark-theme {
    --background-color: #121212; /* Deeper black for a true dark mode */
    --text-color: #f0f0f0; /* Softer white for less eye strain */
    --card-background: #1e1e2f; /* Dark navy with a slight contrast */
    --table-background: #181818; /* Darker shade for better visibility */
    --badge-bg-success: #198754; /* Brighter green for readability */
    --badge-bg-danger: #b02a37; /* More vibrant red */
    --button-bg: #0056b3; /* Deeper blue for a sleek UI */
    --button-text: #ffffff;
}

/* Apply Theme */
body {
    background-color: var(--background-color);
    color: var(--text-color);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.card {
    background-color: var(--card-background);
    color: var(--text-color);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.table {
    background-color: var(--table-background);
    color: var(--text-color);
}

.badge.bg-success {
    background-color: var(--badge-bg-success) !important;
}

.badge.bg-danger {
    background-color: var(--badge-bg-danger) !important;
}

.btn {
    background-color: var(--button-bg);
    color: var(--button-text);
}

/* Default Light Theme */
:root {
    --background-color: #ffffff;
    --text-color: #333;
    --card-background: #f8f9fa;
    --table-background: #ffffff;
    --badge-bg-success: #28a745;
    --badge-bg-danger: #dc3545;
    --button-bg: #007bff;
    --button-text: #fff;
    --table-border: #dee2e6;
}

/* Improved Dark Theme */
.dark-theme {
    --background-color: #121212; /* Deeper black for a true dark mode */
    --text-color: #f0f0f0; /* Softer white for less eye strain */
    --card-background: #1e1e2f; /* Dark navy with a slight contrast */
    --table-background: #181818; /* Darker shade for better visibility */
    --badge-bg-success: #198754; /* Brighter green for readability */
    --badge-bg-danger: #b02a37; /* More vibrant red */
    --button-bg: #0056b3; /* Deeper blue for a sleek UI */
    --button-text: #ffffff;
    --table-border: #3a3a3a;
}

/* Apply Theme */
body {
    background-color: var(--background-color);
    color: var(--text-color);
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Improved card styling */
.card {
    background-color: var(--card-background);
    color: var(--text-color);
    transition: background-color 0.3s ease, color 0.3s ease;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Improved table styling */
.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    background-color: var(--table-background);
    color: var(--text-color);
    border-collapse: collapse;
    border-spacing: 0;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 2px solid var(--table-border);
}

.table th {
    background-color: rgba(0, 123, 255, 0.1);
    color: var(--text-color);
    font-weight: bold;
}

/* Make the table full-width */
#CarTable {
    min-width: 100%;
    table-layout: auto;
}

/* Highlight table rows on hover */
.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.1);
    transition: 0.2s ease-in-out;
}

/* Adjust table for better readability on mobile */
@media (max-width: 768px) {
    .table th, .table td {
        padding: 10px;
        font-size: 14px;
    }
}

/* Badge styles */
.badge.bg-success {
    background-color: var(--badge-bg-success) !important;
}

.badge.bg-danger {
    background-color: var(--badge-bg-danger) !important;
}

/* Buttons */
.btn {
    background-color: var(--button-bg);
    color: var(--button-text);
    padding: 10px 15px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
}

.btn:hover {
    opacity: 0.85;
}

/* Print & Dark Mode button alignment */
.d-flex.justify-content-center {
    margin-top: 20px;
}

/* Smooth transitions */
* {
    transition: all 0.3s ease-in-out;
}
/* Description Styles */
.description {
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limit to 3 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: all 0.3s ease-in-out;
}

.expanded {
    -webkit-line-clamp: unset; /* Remove line limit when expanded */
    overflow: visible;
}


    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Dark Mode Toggle
            const darkModeToggle = $('#darkModeToggle');
            const body = $('body');

            // Check local storage for dark mode preference
            if (localStorage.getItem('dark-mode') === 'enabled') {
                body.addClass('dark-theme');
            }

            darkModeToggle.click(function() {
                body.toggleClass('dark-theme');

                // Save preference to local storage
                if (body.hasClass('dark-theme')) {
                    localStorage.setItem('dark-mode', 'enabled');
                } else {
                    localStorage.setItem('dark-mode', 'disabled');
                }
            });

            // Print Function
            $('#printOrders').click(function() {
                var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                mywindow.document.write('<html><head><title>Orders</title>');
                mywindow.document.write('</head><body >');
                mywindow.document.write('<h1>Orders</h1>');
                mywindow.document.write(document.getElementById('carTableDiv').innerHTML);
                mywindow.document.write('</body></html>');
                mywindow.document.close();
                mywindow.focus();
                mywindow.print();
                mywindow.close();
                return true;
            });
        });
    </script>
@endsection
