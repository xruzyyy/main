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
        Filter by: Not Active
    </button>
    <ul class="dropdown-menu" aria-labelledby="combinedSortFilterButton">
        <li>
            <a class="dropdown-item {{ request()->input('sort') == 'newest' ? 'active' : '' }}" href="{{ route('ManagePost', ['sort' => 'newest', 'limit' => request()->input('limit', 10)]) }}">Newest</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('sort') == 'oldest' ? 'active' : '' }}" href="{{ route('ManagePost', ['sort' => 'oldest', 'limit' => request()->input('limit', 10)]) }}">Oldest</a>
        </li>
        <li>
            <a class="dropdown-item {{ !request()->input('sort') ? 'active' : '' }}" href="{{ route('ManagePost', ['limit' => request()->input('limit', 10)]) }}">Default</a>
        </li>
    </ul>
</div>

<!-- Pagination Limit Dropdown -->
<div class="dropdown float-end">
    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="paginationLimitButton" data-bs-toggle="dropdown" aria-expanded="false">
        Show
        {{ request()->input('limit', 'All') }} per page
    </button>
    <ul class="dropdown-menu" aria-labelledby="paginationLimitButton">
        <li>
            <a class="dropdown-item {{ request()->input('limit', 5) == 5 ? 'active' : '' }}" href="{{ route('ManagePost', ['limit' => 5, 'sort' => request()->input('sort', 'newest')]) }}">5</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 10) == 10 ? 'active' : '' }}" href="{{ route('ManagePost', ['limit' => 10, 'sort' => request()->input('sort', 'newest')]) }}">10</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 20) == 20 ? 'active' : '' }}" href="{{ route('ManagePost', ['limit' => 20, 'sort' => request()->input('sort', 'newest')]) }}">20</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 50) == 50 ? 'active' : '' }}" href="{{ route('ManagePost', ['limit' => 50, 'sort' => request()->input('sort', 'newest')]) }}">50</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 100) == 100 ? 'active' : '' }}" href="{{ route('ManagePost', ['limit' => 100, 'sort' => request()->input('sort', 'newest')]) }}">100</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit') == 'all' ? 'active' : '' }}" href="{{ route('ManagePost', ['limit' => 'all', 'sort' => request()->input('sort', 'newest')]) }}">All</a>
        </li>
    </ul>
</div>
