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
                                @if(request()->input('filter') == 'active')
                                    Active
                                @elseif(request()->input('filter') == 'not_active')
                                    Not Active
                                @else
                                    All <!-- Add a default option -->
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="combinedSortFilterButton">
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
                                    <a class="dropdown-item {{ request()->input('limit', 10) == 5 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 5, 'sort' => request()->input('sort', 'newest')]) }}">5</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->input('limit', 10) == 10 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 10]) }}">10</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->input('limit', 10) == 20 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 20]) }}">20</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->input('limit', 10) == 50 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 50]) }}">50</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->input('limit', 10) == 100 ? 'active' : '' }}" href="{{ route('categories', ['limit' => 100]) }}">100</a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->input('limit') == 'all' ? 'active' : '' }}" href="{{ route('categories', ['limit' => 'all']) }}">All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Business Name</th>
                                    <th>Description</th>
                                    <th>Business Image</th>
                                    <th>Is Active</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $item)
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
                                            <a href="{{ route('categories.toggleStatus', ['id' => $item->id]) }}" class="btn btn-sm btn-{{ $item->is_active ? 'danger' : 'success' }}">
                                                {{ $item->is_active ? 'Disable' : 'Enable' }}
                                            </a>
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
                                                        <a href="#" class="btn btn-danger" onclick="confirmToggleStatus('{{ $item->id }}')">Confirm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Edit and Delete">
                                            <!-- Edit Button -->
                                            <a href="{{ url('categories/'.$item->id.'/edit')}}" class="btn btn-success" title="Edit">
                                                <img src="{{ asset('images/edit.png') }}" alt="Edit Icon" style="width: 20px; height: 20px;"> Edit
                                            </a>
                                                                                
                                            <!-- Delete Button with Confirmation Modal -->
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Delete">
                                                <img src="{{ asset('images/bin.png') }}" alt="Delete Icon" style="width: 15px; height: 20px;"> Delete
                                            </button>
                                        </div>
                                        
                                        
                                        
                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Delete Confirmation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                      Are you sure you want to delete this "{{ $item->businessName }}" business listing?
                                                  </div>                                                  
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <a href="#" class="btn btn-danger" onclick="confirmDelete('{{ $item->id }}', '{{ $item->businessName }}')">Confirm Delete</a>
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

<!-- JavaScript for Delete Confirmation -->
@section('scripts')
    <script>
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
    </script>
@endsection
