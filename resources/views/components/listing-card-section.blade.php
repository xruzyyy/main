<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<div class="d-flex align-items-end">
    <div class="flex-grow-1">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h3 class="card-title">{{ $count['listing'] ?? 0 }} Total Listing</h3>
                        <button type="button" class="btn btn-light">
                            <i class="fas fa-list"></i> All Listings
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        <h3 class="card-title" style="color:white;">{{ $count['active_listings'] ?? 0 }} Total Active Listing</h3>
                        <button type="button" class="btn btn-light">
                            <i class="fas fa-check-circle"></i> Total Active Listing
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add a new row after every 2 columns -->
            <div class="w-100"></div>

            <div class="col-md-6 mb-4">
                <div class="card bg-warning text-dark shadow">
                    <div class="card-body">
                        <h3 class="card-title" style="color: white">{{ $count['inactive_listings'] ?? 0}} Total Inactive Listings</h3>
                        <button type="button" class="btn btn-light">
                            <i class="fas fa-times-circle"></i> Total Inactive Listings
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <h3 class="card-title">{{ $count['expired_listings'] ?? 0 }} Expired Listing</h3>
                        <button type="button" class="btn btn-light">
                            <i class="fas fa-exclamation-circle"></i> No. Of Expired
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Pie  -->
        <div>
            <canvas id="myChartPie" width="360" height="240" style="border-radius: 2em;"></canvas>
        </div>
    </div>
</div>
