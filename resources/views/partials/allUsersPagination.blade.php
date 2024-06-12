<div class="dropdown float-end mx-2">
    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="combinedSortFilterButton2" data-bs-toggle="dropdown" aria-expanded="false">
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
        @if(request()->input('filter') == 1)
            Active
        @elseif(request()->input('filter') == 0)
            Not Active
        @elseif(request()->input('filter') == 3)
            Rejected <!-- Add Rejected option -->
        @else
            All <!-- Add a default option -->
        @endif
    </button>
    <ul class="dropdown-menu" aria-labelledby="combinedSortFilterButton">
        <li>
            <a class="dropdown-item {{ request()->input('sort') == 'newest' ? 'active' : '' }}" href="{{ route('users.sortTable', ['sort' => 'newest', 'filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Newest</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('sort') == 'oldest' ? 'active' : '' }}" href="{{ route('users.sortTable', ['sort' => 'oldest', 'filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Oldest</a>
        </li>
        <li>
            <a class="dropdown-item {{ !request()->input('sort') ? 'active' : '' }}" href="{{ route('users.sortTable', ['filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Default</a>
        </li>
        <li class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item {{ request()->input('filter') == 1 ? 'active' : '' }}" href="{{ route('users.sortTable', ['sort' => request()->input('sort', 'newest'), 'filter' => 1, 'limit' => request()->input('limit', 10)]) }}">Active</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('filter') == 0 ? 'active' : '' }}" href="{{ route('users.sortTable', ['sort' => request()->input('sort', 'newest'), 'filter' => 0, 'limit' => request()->input('limit', 10)]) }}">Not Active</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('filter') == 3 ? 'active' : '' }}" href="{{ route('users.sortTable', ['sort' => request()->input('sort', 'newest'), 'filter' => 3, 'limit' => request()->input('limit', 10)]) }}">Rejected</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('filter') == 'all' ? 'active' : '' }}" href="{{ route('users.sortTable', ['sort' => request()->input('sort', 'newest'), 'limit' => request()->input('limit', 10)]) }}">All</a>
        </li>
    </ul>
</div>

<!-- Pagination Limit Dropdown -->
<div class="dropdown float-end">
    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="paginationLimitButton" data-bs-toggle="dropdown" aria-expanded="false">
        Show
        {{ request()->input('limit', 'All') }} per page <!-- Set default value to 'All' -->
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="paginationLimitButton">
        <li>
            <a class="dropdown-item {{ request()->input('limit', 5) == 5 ? 'active' : '' }}" href="{{ route('users.sortTable', ['limit' => 5, 'sort' => request()->input('sort', 'newest'), 'filter' => request()->input('filter', 'all')]) }}">5</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 10) == 10 ? 'active' : '' }}" href="{{ route('users.sortTable', ['limit' => 10, 'sort' => request()->input('sort', 'newest'), 'filter' => request()->input('filter', 'all')]) }}">10</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 20) == 20 ? 'active' : '' }}" href="{{ route('users.sortTable', ['limit' => 20, 'sort' => request()->input('sort', 'newest'), 'filter' => request()->input('filter', 'all')]) }}">20</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 50) == 50 ? 'active' : '' }}" href="{{ route('users.sortTable', ['limit' => 50, 'sort' => request()->input('sort', 'newest'), 'filter' => request()->input('filter', 'all')]) }}">50</a>
        </li>
        <li>
            <li>
                <a class="dropdown-item {{ request()->input('limit', 100) == 100 ? 'active' : '' }}" href="{{ route('users.sortTable', ['limit' => 100, 'sort' => request()->input('sort', 'newest'), 'filter' => request()->input('filter', 'all')]) }}">100</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->input('limit') == 'all' ? 'active' : '' }}" href="{{ route('users.sortTable', ['limit' => 'all', 'sort' => request()->input('sort', 'newest'), 'filter' => request()->input('filter', 'all')]) }}">All</a>
            </li>
        </ul>
    </div>
