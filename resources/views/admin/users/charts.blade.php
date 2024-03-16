@extends('layouts.master')

@section('content-business')
<div class="row">
    <div class="col-md-6">
        <canvas id="pieChart" width="400" height="400"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="barGraph" width="400" height="400"></canvas>
    </div>
</div>

<!-- Your existing table code goes here -->
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <!-- Your table content -->
</table>
@endsection

@section('styles')
<!-- Include any additional styles here -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Code to fetch data for pie chart and bar graph
        var activeUsersCount = <?php echo json_encode($activeUsersCount); ?>;
        var inactiveUsersCount = <?php echo json_encode($inactiveUsersCount); ?>;

        // Pie Chart
        var pieData = {
            labels: ['Active Users', 'Inactive Users'],
            datasets: [{
                data: [activeUsersCount, inactiveUsersCount],
                backgroundColor: ['#007bff', '#dc3545']
            }]
        };

        var pieChartOptions = {
            responsive: true,
            maintainAspectRatio: false
        };

        var pieChart = new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: pieData,
            options: pieChartOptions
        });

        // Bar Graph
        var barData = {
            labels: ['Active Users', 'Inactive Users'],
            datasets: [{
                label: 'User Count',
                data: [activeUsersCount, inactiveUsersCount],
                backgroundColor: ['#007bff', '#dc3545']
            }]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        var barChart = new Chart(document.getElementById('barGraph'), {
            type: 'bar',
            data: barData,
            options: barChartOptions
        });
    });
</script>
@endsection
