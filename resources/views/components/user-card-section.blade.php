<!-- resources/views/admin/includes/left/left-sidebar.blade.php -->
<div class="d-flex align-items-start" style="width: 100px; height:100px;">
    <div class="flex-grow-1">
        <div class="flex-container text-center">
            <div style="background:rgb(32, 218, 193); margin:10px; padding: 10px; border-radius: 8px; text-align: center;">
                <h3 class="mb-2">{{ $count['users'] ?? 0 }}</h3>
                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="show-not-expired">
                    <button type="submit" class="btn" style="background:rgba(32, 218, 193,0);">Total Active Users</button>
                </form>
            </div>
            <div style="background:goldenrod; margin:10px;">
                <h3 class="mb-2">{{ $count['inactive'] ?? 0 }}</h3>
                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="show-inactive-list">
                    <button type="submit" class="btn" style=" background:rgba(3, 80, 247, 0);">Total Inactive Users</button>
                </form>
            </div>
            <div style="background:rgba(3, 80, 247, 0.568); margin:10px;">
                <h3 class="mb-2">{{ $count['active'] ?? 0 }} Business</h3>
                 <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                     @csrf
                     <input type="hidden" name="action" value="show-not-expired">
                    <button type="submit" class="btn" style="rgba(3, 80, 247, 0.568); margin:10px;">Show Active Users</button>
                </form>
            </div>
            <div style="background:rgba(247, 3, 56, 0.568); margin:10px;">
                <h3 class="mb-2">{{ $count['expired'] ?? 0 }} Expired</h3>
                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="check-new-expired">
                    <button type="submit" class="btn" style="background:rgba(247, 3, 56,0; margin:10px;">Disable All Expired</button>
                </form>
            </div>
        </div>
        <!-- Chart DateCreation -->
        <div>
            <canvas id="userCreationLineChart" width="00" height="200"></canvas>
        </div>
       
        <!-- Chart 2: Bar Chart -->
        <div>
            <canvas id="myChartBar" width="150" height="100"></canvas>
        </div>
        
    </div>
</div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
            var ctxbar = document.getElementById('myChartBar').getContext('2d');

            var myChartBar = new Chart(ctxbar, {
                type: 'bar',
            data: {
                labels: ['Total Of All Users', 'Total Of Inactive Business Users', 'Total Active Business Users', 'Total Of Expired Business Users'],
                datasets: [{
                    label: 'All Users Data',
                    data: [{{ $count['users'] ?? 0 }}, {{ $count['inactive'] ?? 0 }}, {{ $count['active'] ?? 0 }}, {{ $count['expired'] ?? 0 }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top' // or 'top', 'left', 'right'
                    }
                }
            }
        });


        document.addEventListener('DOMContentLoaded', function () {
    var ctxLine = document.getElementById('userCreationLineChart').getContext('2d');

    var userCreationData = @json($userCreationData);
    var normalUserCreationData = @json($normalUserCreationData);

    var dates = [];
    var userCounts = [];
    var normalUserCounts = [];

    // Extract dates and counts for user creation data
    userCreationData.forEach(function (data) {
        dates.push(data.date);
        userCounts.push(data.count);
    });

    // Extract dates and counts for normal user creation data
    normalUserCreationData.forEach(function (data) {
        dates.push(data.date);
        normalUserCounts.push(data.count);
    });

    var userCreationLineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: 'Business Users Created',
                    data: userCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Normal Users Created',
                    data: normalUserCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});


        var ctxPie = document.getElementById('myChartPie').getContext('2d');

        var myChartPie = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Total Of Active Listings', 'Total Of Inactive Listings', 'Total Of Expired Listings'],
                datasets: [{
                    label: 'All Listings Data',
                    data: [ {{ $count['active_listings'] ?? 0 }}, {{ $count['inactive_listings'] ?? 0 }}, {{ $count['expired_listings'] ?? 0 }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

    </script>
@endsection
