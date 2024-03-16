@extends('layouts.master')

@section('manageUsers')
<div class="container p-4">
    <div class="text-center">
        <h1 class="">Manage All Accounts</h1>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-md btn-primary">Add Business User</a>

    <!-- Combined Dropdown for Sorting and Filtering -->
    <div class="dropdown float-end mx-2">
        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="combinedSortFilterButton" data-bs-toggle="dropdown" aria-expanded="false">
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
                <a class="dropdown-item {{ !request()->input('filter') ? 'active' : '' }}" href="{{ route('users.sortTable', ['sort' => request()->input('sort', 'newest'), 'limit' => request()->input('limit', 10)]) }}">All</a>
            </li>
        </ul>
    </div>

    <!-- Pagination Limit Dropdown -->
    <div class="dropdown float-end">
        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="paginationLimitButton" data-bs-toggle="dropdown" aria-expanded="false">
            Show
            @if(request()->input('limit') == 'all')
                All
            @else
                {{ request()->input('limit', 10) }}
            @endif
            per page
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="paginationLimitButton">
            <li>
                <a class="dropdown-item {{ request()->input('limit', 5) == 5 ? 'active' : '' }}" href="{{ route('users', ['limit' => 5, 'sort' => request()->input('sort', 'newest')]) }}">5</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->input('limit', 10) == 10 ? 'active' : '' }}" href="{{ route('users', ['limit' => 10, 'sort' => request()->input('sort', 'newest')]) }}">10</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->input('limit', 20) == 20 ? 'active' : '' }}" href="{{ route('users', ['limit' => 20, 'sort' => request()->input('sort', 'newest')]) }}">20</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->input('limit', 50) == 50 ? 'active' : '' }}" href="{{ route('users', ['limit' => 50, 'sort' => request()->input('sort', 'newest')]) }}">50</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->input('limit', 100) == 100 ? 'active' : '' }}" href="{{ route('users', ['limit' => 100, 'sort' => request()->input('sort', 'newest')]) }}">100</a>
            </li>
            <li>
                <a class="dropdown-item {{ request()->input('limit') == 'all' ? 'active' : '' }}" href="{{ route('users', ['limit' => 'all', 'sort' => request()->input('sort', 'newest')]) }}">All</a>
            </li>
        </ul>
    </div>

    <!-- Table with DataTables integration -->
    <table id="example" class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Business Email</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <!-- Add a link around the image to trigger the modal -->
                    <a href="#" class="image-preview" data-bs-toggle="modal" data-bs-target="#imageModal{{ $user->id }}">
                        <img src="{{ asset($user->image) }}" style="width: 70px; height: 70px;" alt="">
                    </a>
                </td>
                <td>
                    <a href="{{ route('users.toggleStatus', $user->id) }}" class="btn btn-sm btn-{{ $user->status ? 'success' : 'danger' }}">
                        {{ $user->status ? 'Enable' : 'Disable' }}
                    </a>
                </td>

                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modals -->
@foreach ($users as $user)
<div class="modal fade" id="imageModal{{ $user->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display the larger image -->
                <div class="image-container">
                    <img src="{{ asset($user->image) }}" class="img-fluid" alt="" id="zoomedImage">
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Back to Top Button -->
<button onclick="topFunction()" id="backToTopBtn" title="Go to top"></button>

@endsection

@section('styles')
<style>
    /* Custom CSS for the table */
    #example_wrapper {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    #example_length label {
        font-weight: bold;
    }
    #example_filter input {
        border: 1px solid #ccc;
        border-radius: 20px;
        padding: 8px 15px;
        transition: border-color 0.3s ease;
    }
    #example_filter input:focus {
        border-color: #007bff;
        outline: none;
    }
    #example_paginate .paginate_button {
        padding: 8px 15px;
        margin: 0 5px;
        border-radius: 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        transition: background-color 0.3s ease;
    }
    #example_paginate .paginate_button:hover {
        background-color: #0056b3;
    }
    #example_paginate .paginate_button.disabled {
        background-color: #6c757d;
    }
    #example_paginate .paginate_button.current {
        background-color: #0056b3;
    }

    /* Custom CSS for the dropdown menu */
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.25rem;
    }
    .dropdown-menu .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #495057;
    }

    /* Custom CSS for the columns dropdown button */
    .btn-secondary.dropdown-toggle {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-secondary.dropdown-toggle:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .btn-secondary.dropdown-toggle:focus {
        box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.5);
    }

    /* Custom CSS for the DataTables links */
    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px; /* Added margin */
    }

    /* Custom CSS for the buttons-columnVisibility */
    .buttons-columnVisibility {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 14px;
        margin-right: 10px;
        margin-bottom: 10px; /* Added margin */
    }

    .buttons-columnVisibility.active {
        background-color: #2333c8;
        border-color: #3121bd;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 70, 0);
    }
    .dataTables_length {
     display: none;
    }   

  

    .dataTables_info {
        visibility: visible; /* Ensure pagination info is visible */
    }

    /* Back to Top Button */
#backToTopBtn {
    display: none;
    position: fixed;
    bottom: 70px;
    right: 10px;
    z-index: 99;
    border: none;
    outline: none;
    background-color: #000000;
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 50%;
    transition: background-color 0.3s ease, transform 0.3s ease;
    animation: fadeIn 0.3s;
}

#backToTopBtn:hover {
    background-color: crimson;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Add a subtle shadow on hover */
    transform: scale(1.1); /* Enlarge slightly on hover */
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: scale(0);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

/* FontAwesome Icon */
#backToTopBtn::before {
    content: "\f062"; /* Unicode for FontAwesome arrow-up icon */
    font-family: "Font Awesome 5 Free"; /* Use FontAwesome font family */
    font-weight: 900;
    font-size: 20px;
}

/* Hide the default browser scrollbar */
body::-webkit-scrollbar {
    display: none;
}


</style>
@endsection

@section('scripts')
<!-- Include jQuery and DataTables JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
        // Get the current limit parameter from the URL
        var defaultLimit = {{ request()->input('limit' , 0) }};
        
        // DataTable initialization
        var table = $('#example').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center"Bf><"clear">lirtp',
            "paging": true,
            "lengthMenu": [[5, 10, 20, 50, 100, -1], [5, 10, 20, 50, 100, "All"]],
            "pageLength": defaultLimit, // Set the default page length
            "autoWidth": true,
            "language": {
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            },"buttons": [
                {
                    extend: 'colvis',
                    text: 'Columns',
                    className: 'btn btn-secondary dropdown-toggle',
                    attr: {
                        'aria-haspopup': true,
                        'aria-expanded': false,
                        'data-toggle': 'dropdown'
                    },
                    dropdown: {
                        className: 'dropdown-menu dropdown-menu-right'
                    }
                },
                {
                    extend: 'copyHtml5',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'csvHtml5',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'print',
                    className: 'btn btn-secondary'
                }
            ]
        });
    });
    

// Back to Top Button Functionality
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("backToTopBtn").style.display = "block";
    } else {
        document.getElementById("backToTopBtn").style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

</script>
@endsection
