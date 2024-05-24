<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<div class="d-flex align-items-start" style="width: 100%;">
    <div class="flex-grow-1">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h3 class="card-title">{{ $count['users'] ?? 0 }} Total Active Users</h3>
                        <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                            @csrf
                            <input type="hidden" name="action" value="show-not-expired">
                            <button type="submit" class="btn btn-light">Show Active Users <i class="fas fa-users"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card bg-warning text-dark shadow">
                    <div class="card-body">
                        <h3 class="card-title">{{ $count['inactive'] ?? 0 }} Total Inactive Users</h3>
                        <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                            @csrf
                            <input type="hidden" name="action" value="show-inactive-list">
                            <button type="submit" class="btn btn-light">Show Inactive Users <i class="fas fa-user-slash"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        <h3 class="card-title">{{ $count['active'] ?? 0 }} Total Active Businesses</h3>
                         <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                             @csrf
                             <input type="hidden" name="action" value="show-not-expired">
                            <button type="submit" class="btn btn-light">Show Active Businesses <i class="fas fa-business-time"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <h3 class="card-title">{{ $count['expired'] ?? 0 }} Total Expired Businesses</h3>
                        <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                            @csrf
                            <input type="hidden" name="action" value="check-new-expired">
                            <button type="submit" class="btn btn-light">Disable All Expired <i class="fas fa-calendar-times"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart DateCreation -->
        <div class="mb-4">
            <canvas id="userCreationLineChart" width="350" height="200"></canvas>
        </div>

        <!-- Chart 2: Bar Chart -->
        <div>
            <canvas id="myChartBar"  width="360" height="240" style="border-radius: 2em;"></canvas>
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
                    label: 'Client Users Created',
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

