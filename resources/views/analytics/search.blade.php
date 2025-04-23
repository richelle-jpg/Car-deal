@extends('layouts.appCustomer')

@section('m-content')
    <div class="container">
        <h2>Search History Analytics</h2>

        <form action="{{ route('analytics.search') }}" method="GET">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="{{ request('start_date', $startDate->toDateString()) }}">

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="{{ request('end_date', $endDate->toDateString()) }}">

            <button type="submit">Filter</button>
        </form>

        <h3>Search History Chart</h3>
        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script>
            var budgetLabels = @json($budgetLabels);  // Data passed from controller (budget ranges)
            var searchCounts = @json($searchCounts);  // Data passed from controller (number of searches)

            new Chart("myChart", {
                type: "line",  // Change this to "bar" or another chart type if you want
                data: {
                    labels: budgetLabels,  // Budget range labels
                    datasets: [{
                        fill: false,
                        lineTension: 0,  // Controls curve smoothness
                        backgroundColor: "rgba(0,0,255,1)",  // Line color
                        borderColor: "rgba(0,0,255,0.2)",  // Border color (lighter blue)
                        data: searchCounts,  // Data for the number of searches
                        borderWidth: 2  // Border thickness
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Search History Based on Budget Range'
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {min: 0},  // Ensures the Y axis starts at 0
                            scaleLabel: {
                                display: true,
                                labelString: 'Number of Searches'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Budget Range'
                            }
                        }]
                    }
                }
            });
        </script>

        <!-- Search History Table -->
        <table>
            <thead>
                <tr>
                    <th>Budget Range</th>
                    <th>Number of Searches</th>
                </tr>
            </thead>
            <tbody>
                @foreach($searchHistories as $history)
                    <tr>
                        <td>{{ $history->budget }}</td>
                        <td>{{ $history->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection