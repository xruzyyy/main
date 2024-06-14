<!-- Combined Dropdown for Sorting and Filtering -->
<div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        Sort by:
            @if(request()->input('sort') == 'newest')
                Newest
            @elseif(request()->input('sort') == 'oldest')
                Oldest
            @else
                Default <!-- Add a default option -->
            @endif
            &nbsp;/&nbsp;
            Filter by:
            @if(request()->input('filter') == 'active')
                Active
            @elseif(request()->input('filter') == 'not_active')
                Not Active
            @else
                All <!-- Add a default option -->
            @endif
    </button>
    <ul class="dropdown-menu">
        <!-- Dropdown menu items -->
        <li>
            <a class="dropdown-item {{ request()->input('sort') == 'newest' ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['sort' => 'newest', 'filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Newest</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('sort') == 'oldest' ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['sort' => 'oldest', 'filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Oldest</a>
        </li>
        <li>
            <a class="dropdown-item {{ !request()->input('sort') ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Default</a>
        </li>
        <li class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item {{ request()->input('filter') == 'active' ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['sort' => request()->input('sort', 'newest'), 'filter' => 'active', 'limit' => request()->input('limit', 10)]) }}">Active</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('filter') == 'not_active' ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['sort' => request()->input('sort', 'newest'), 'filter' => 'not_active', 'limit' => request()->input('limit', 10)]) }}">Not Active</a>
        </li>
        <li>
            <a class="dropdown-item {{ !request()->input('filter') ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['sort' => request()->input('sort', 'newest'), 'limit' => request()->input('limit', 10)]) }}">All</a>
        </li>
    </ul>
</div>

<!-- Pagination Limit Dropdown -->
<div class="dropdown float-end">
<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
Show
@if(request()->input('limit') == 'all')
All
@else
{{ request()->input('limit', 10) }}
@endif
per page
</button>
<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<li>
<a class="dropdown-item {{ request()->input('limit', 10) == 5 ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['limit' => 5, 'sort' => request()->input('sort', 'newest')]) }}">5</a>
</li>
<li>
<a class="dropdown-item {{ request()->input('limit', 10) == 10 ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['limit' => 10, 'sort' => request()->input('sort', 'newest')]) }}">10</a>
</li>
<li>
<a class="dropdown-item {{ request()->input('limit', 10) == 20 ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['limit' => 20, 'sort' => request()->input('sort', 'newest')]) }}">20</a>
</li>
<li>
<a class="dropdown-item {{ request()->input('limit', 10) == 50 ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['limit' => 50, 'sort' => request()->input('sort', 'newest')]) }}">50</a>
</li>
<li>
<a class="dropdown-item {{ request()->input('limit', 10) == 100 ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['limit' => 100, 'sort' => request()->input('sort', 'newest')]) }}">100</a>
</li>
<li>
<a class="dropdown-item {{ request()->input('limit') == 'all' ? 'active' : '' }}" href="{{ route('ManagePost.sort', ['limit' => 'all', 'sort' => request()->input('sort', 'newest')]) }}">All</a>
</li>
</ul>
</div>
