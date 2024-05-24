@extends('layouts.master')

@section('ManagePost')
    <!-- Main content for this view -->
    <div class="container mx-auto p-1">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Business List</h4>
                        <a href="{{ url('ManagePost/create') }}" class="btn btn-primary float-end ms-2 mb-2">Add Listing</a>
                        @include('partials.allBusinessListPagination')
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Your table body -->
                                    @foreach ($ManagePost as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->businessName }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                <!-- Add a link around the image to trigger the modal -->
                                                <a href="#" class="image-preview" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal{{ $item->id }}">
                                                    <!-- Display only the first image from the array -->
                                                    @php
                                                        $images = json_decode($item->images);
                                                        $firstImage = isset($images[0]) ? $images[0] : null;
                                                    @endphp
                                                    <img src="{{ asset($firstImage) }}" style="height: 50px; width:50px;"
                                                        class="card-img-top" alt="Business Image"
                                                        onclick="openFullScreen('{{ route('businessPost', ['id' => $item->id]) }}')">
                                                </a>

                                                <!-- Modal for image preview -->
                                                <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="imageModalLabel" aria-hidden="true"
                                                    style="z-index: 9999;">
                                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="imageModalLabel">Image Preview
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Display the larger image -->
                                                                <div class="image-container">
                                                                    <!-- Display only the first image from the array -->
                                                                    @php
                                                                        $images = json_decode($item->images);
                                                                        $firstImage = isset($images[0])
                                                                            ? $images[0]
                                                                            : null;
                                                                    @endphp
                                                                    <img src="{{ asset($firstImage) }}" class="card-img-top"
                                                                        alt="Business Image"
                                                                        onclick="openFullScreen('{{ route('businessPost', ['id' => $item->id]) }}')">
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
                                                <a href="#"
                                                    class="btn btn-sm btn-{{ $item->is_active ? 'danger' : 'success' }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#toggleStatusModal{{ $item->id }}">
                                                    {{ $item->is_active ? 'Disable' : 'Enable' }}
                                                </a>

                                                <div class="modal fade" id="toggleStatusModal{{ $item->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="toggleStatusModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="toggleStatusModalLabel{{ $item->id }}">Toggle
                                                                    Status Confirmation</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to
                                                                {{ $item->is_active ? 'disable' : 'enable' }} this
                                                                "{{ $item->businessName }}" business listing?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <a href="#"
                                                                    class="btn {{ $item->is_active ? 'btn-danger' : 'btn-success' }}"
                                                                    onclick="confirmToggleStatus('{{ $item->id }}')">
                                                                    Confirm
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>


                                            <td>
                                                <div class="btn-group" role="group" aria-label="Edit and Delete">
                                                    <a href="{{ url('ManagePost/' . $item->id . '/edit') }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <img src="{{ asset('images/edit.png') }}" alt="Edit Icon"
                                                            style="width: 20px; height: 20px;"> Edit
                                                    </a>
                                                    <!-- Delete Button with Confirmation Modal -->
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->id }}" title="Delete">
                                                        <img src="{{ asset('images/bin.png') }}" alt="Delete Icon"
                                                            style="width: 15px; height: 20px;"> Delete
                                                    </button>
                                                </div>
                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Confirm
                                                                    Deletion</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this listing
                                                                '<strong>{{ $item->businessName }}</strong>'?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <!-- Form for Deletion -->
                                                                <form
                                                                    action="{{ url('ManagePost/' . $item->id . '/delete') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
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

    @section('scriptsManageAllBusiness')
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
                    "lengthMenu": [
                        [5, 10, 20, 50, 100, -1],
                        [5, 10, 20, 50, 100, "All"]
                    ],
                    "pageLength": defaultLimit, // Set the default page length
                    "autoWidth": true,
                    "language": {
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries"
                    },
                    "order": [],
                    "buttons": [{
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
                    window.location.href = "{{ url('ManagePost') }}/" + id + "/toggleStatus";
                }
            }

            function confirmDelete(id) {
                if (confirm) {
                    // Redirect to the delete route with the record ID
                    window.location.href = "{{ url('ManagePost') }}/" + id + "/delete";
                }
            }

            // Back to Top Button Functionality
            window.onscroll = function() {
                scrollFunction()
            };

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
