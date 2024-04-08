@extends('layouts.master')

@section('categories')
<!-- Main content for this view -->
<div class="container mx-auto p-1">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Business List</h4>
                    <a href="{{ url('categories/create') }}" class="btn btn-primary float-end ms-2 mb-2">Add Listing</a>

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
                                <a class="dropdown-item {{ request()->input('sort') == 'newest' ? 'active' : '' }}" href="{{ route('categories', ['sort' => 'newest', 'filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Newest</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->input('sort') == 'oldest' ? 'active' : '' }}" href="{{ route('categories', ['sort' => 'oldest', 'filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Oldest</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ !request()->input('sort') ? 'active' : '' }}" href="{{ route('categories', ['filter' => request()->input('filter', 'all'), 'limit' => request()->input('limit', 10)]) }}">Default</a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item {{ request()->input('filter') == 'active' ? 'active' : '' }}" href="{{ route('categories', ['sort' => request()->input('sort', 'newest'), 'filter' => 'active', 'limit' => request()->input('limit', 10)]) }}">Active</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->input('filter') == 'not_active' ? 'active' : '' }}" href="{{ route('categories', ['sort' => request()->input('sort', 'newest'), 'filter' => 'not_active', 'limit' => request()->input('limit', 10)]) }}">Not Active</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ !request()->input('filter') ? 'active' : '' }}" href="{{ route('categories', ['sort' => request()->input('sort', 'newest'), 'limit' => request()->input('limit', 10)]) }}">All</a>
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
            <a class="dropdown-item {{ request()->input('limit', 10) == 5 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 5, 'sort' => request()->input('sort', 'newest')]) }}">5</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 10) == 10 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 10, 'sort' => request()->input('sort', 'newest')]) }}">10</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 10) == 20 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 20, 'sort' => request()->input('sort', 'newest')]) }}">20</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 10) == 50 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 50, 'sort' => request()->input('sort', 'newest')]) }}">50</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit', 10) == 100 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 100, 'sort' => request()->input('sort', 'newest')]) }}">100</a>
        </li>
        <li>
            <a class="dropdown-item {{ request()->input('limit') == 'all' ? 'active' : '' }}" href="{{ route('categories', ['limit' => 'all', 'sort' => request()->input('sort', 'newest')]) }}">All</a>
        </li>
    </ul>
</div>


                <div class="card-body">
                    <!-- Table with DataTables integration -->
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Business Name</th>
                                <th>Description</th>
                                <th>Business Image</th>
                                <th>Is Active</th>
                                <th>Status</th>
                                <th>User ID</th> <!-- New column for user ID -->
                                <th>User Email</th> <!-- New column for user email -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Your table body -->
                            @foreach ($categories as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->businessName }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <!-- Add a link around the image to trigger the modal -->
                                    <a href="#" class="image-preview" data-bs-toggle="modal" data-bs-target="#imageModal{{ $item->id }}">
                                        <img src="{{ asset($item->image) }}" style="width: 70px; height: 70px;" alt="">
                                    </a>

                                    <!-- Modal for image preview -->
                                    <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true" style="z-index: 9999;">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Display the larger image -->
                                                    <div class="image-container">
                                                        <img src="{{ asset($item->image) }}" class="img-fluid" alt="" id="zoomedImage">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->is_active)
                                        <span class="badge bg-primary">Active</span>
                                    @else
                                        <span class="badge bg-warning">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Add confirmation modal for enabling and disabling -->
                                    <a href="#" class="btn btn-sm btn-{{ $item->is_active ? 'danger' : 'success' }}" data-bs-toggle="modal" data-bs-target="#toggleStatusModal{{ $item->id }}">
                                        {{ $item->is_active ? 'Disable' : 'Enable' }}
                                    </a>
                                    
                                    <div class="modal fade" id="toggleStatusModal{{ $item->id }}" tabindex="-1" aria-labelledby="toggleStatusModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="toggleStatusModalLabel{{ $item->id }}">Toggle Status Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to {{ $item->is_active ? 'disable' : 'enable' }} this "{{ $item->businessName }}" business listing?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="#" class="btn {{ $item->is_active ? 'btn-danger' : 'btn-success' }}" onclick="confirmToggleStatus('{{ $item->id }}')">
                                                        Confirm
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </td>
                                <td>
                                    <!-- Add user's ID -->
                                    {{ $item->user_id }}
                                </td>
                                <td>
                                    <!-- Add user's email -->
                                    @if ($item->user)
                                        {{ $item->user->email }}
                                    @endif
                                </td>
                                
                                
                                <td>
                                    <div class="btn-group" role="group" aria-label="Edit and Delete">
                                        <a href="{{ url('categories/'.$item->id.'/edit')}}" class="btn btn-warning btn-sm" title="Edit">
                                            <img src="{{ asset('images/edit.png') }}" alt="Edit Icon" style="width: 20px; height: 20px;"> Edit
                                        </a>
                                        <!-- Delete Button with Confirmation Modal -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Delete">
                                            <img src="{{ asset('images/bin.png') }}" alt="Delete Icon" style="width: 15px; height: 20px;"> Delete
                                        </button>
                                    </div>
                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this listing '<strong>{{ $item->businessName }}</strong>'?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <!-- Form for Deletion -->
                                                    <form action="{{ url('categories/'.$item->id.'/delete') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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
        var defaultLimit = {{ request()->input('All', 10) }};

        // DataTable initialization
        var table = $('#example').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center"Bf><"clear">lirtp',
            "paging": true,
            "lengthMenu": [[5, 10, 20, 50, 100, -1], [5, 10, 20, 50, 100, "All"]],
            "pageLength": defaultLimit, // Set the default page length
            "autoWidth": true,
            "language": {
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            },
            "buttons": [
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
    

    


function confirmToggleStatus(id) {
        if (confirm) {
            // Redirect to the toggle status route with the category ID
            window.location.href = "{{ url('categories') }}/" + id + "/toggleStatus";
        }
    }

        function confirmDelete(id) {
            if (confirm) {
                // Redirect to the delete route with the record ID
                window.location.href = "{{ url('categories') }}/" + id + "/delete";
            }
        }

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
