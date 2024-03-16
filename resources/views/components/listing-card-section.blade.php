<!-- resources/views/admin/includes/right/right-sidebar.blade.php -->
<div class="d-flex align-items-end">
    <div class="flex-grow-1">
        <div class="flex-container text-center">
            <div style="background:rgb(32, 218, 193); margin:10px; padding: 10px; border-radius: 8px; text-align: center;">
                <h3 class="mb-2">{{ $count['listing'] ?? 0 }}Total Listing</h3>
                 <form action="{{ route('categories') }}" method="post" class="d-inline">
                     @csrf
                     <input type="hidden" name="action" value="show-not-expired">
                    <button type="submit" class="btn" style="">All Listings</button>
                </form>
            </div>
            <div style="background:rgba(3, 80, 247, 0.568); margin:10px;">
                <h3 class="mb-2">{{ $count['active_listings'] ?? 0 }}</h3>
                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="show-not-expired">
                    <button type="submit" class="btn" style="background:rgba(247, 3, 56, 0);">Total Active Listing</button>
                </form>
            </div>
            <div style="background:goldenrod; margin:10px;">
                <h3 class="mb-2">{{ $count['inactive_listings'] ?? 0}}</h3>
                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="show-inactive-list">
                    <button type="submit" class="btn" style=" background:rgba(3, 80, 247, 0);">Total Inactive Listings</button>
                </form>
            </div>
            <div style="background:rgba(247, 3, 56, 0.568); margin:10px;">
                <h3 class="mb-2">{{ $count['expired_listings'] ?? 0 }} Expired Listing</h3>
                <form action="{{ route('categories') }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="action" value="check-new-expired">
                    <button type="submit" class="btn" style="">Disable All Expired</button>
                </form>
            </div>
        </div>
        
         <!-- Chart Pie  -->
        <div>
            <canvas id="myChartPie" width="500" height="500"></canvas>
        </div>
       
       
        
    </div>
</div>



