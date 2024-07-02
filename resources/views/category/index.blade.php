@extends('layouts.master')

@section('ManagePost')
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Business List</h4>
                        <a href="{{ url('ManagePost/create') }}" class="btn btn-light">
                            <i class="fas fa-plus"></i> Add Listing
                        </a>
                    </div>
                    <div class="card-body">
                        @include('partials.allBusinessListPagination')
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Description</th>
                                        <th>Business Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ManagePost as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->businessName }}</td>
                                            <td>{{ Str::limit($item->description, 50) }}</td>
                                            <td>
                                                <a href="#" class="image-preview" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal{{ $item->id }}">
                                                    @php
                                                        $images = json_decode($item->images);
                                                        $firstImage = isset($images[0]) ? $images[0] : null;
                                                    @endphp
                                                    <img src="{{ asset($firstImage) }}" class="img-thumbnail" style="height: 50px; width:50px;"
                                                        alt="Business Image">
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $item->is_active ? 'success' : 'warning' }}">
                                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ url('ManagePost/' . $item->id . '/edit') }}"
                                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->id }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    {{-- <button class="btn btn-sm btn-outline-{{ $item->is_active ? 'warning' : 'success' }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#toggleStatusModal{{ $item->id }}" title="{{ $item->is_active ? 'Disable' : 'Enable' }}">
                                                        <i class="fas fa-{{ $item->is_active ? 'pause' : 'play' }}"></i>
                                                    </button> --}}
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Image Modal -->
                                        <div class="modal fade" id="imageModal{{ $item->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Image Preview</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset($firstImage) }}" class="img-fluid rounded" alt="Business Image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <!-- Toggle Status Modal -->
                                        <div class="modal fade" id="toggleStatusModal{{ $item->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Status Change</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to {{ $item->is_active ? 'disable' : 'enable' }}
                                                        "{{ $item->businessName }}"?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <a href="#" class="btn btn-{{ $item->is_active ? 'warning' : 'success' }}"
                                                            onclick="confirmToggleStatus('{{ $item->id }}')">
                                                            Confirm
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this listing
                                                        '<strong>{{ $item->businessName }}</strong>'?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <form action="{{ url('ManagePost/' . $item->id . '/delete') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptsManageAllBusiness')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var defaultLimit = {{ request()->input('All', 10) }};

            var table = $('#example').DataTable({
                "dom": '<"d-flex justify-content-between align-items-center mb-3"Bf><"clear">lirtp',
                "paging": true,
                "lengthMenu": [
                    [5, 10, 20, 50, 100, -1],
                    [5, 10, 20, 50, 100, "All"]
                ],
                "pageLength": defaultLimit,
                "autoWidth": true,
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries"
                },
                "order": [],
                "buttons": [{
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Columns',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-secondary'
                    }
                ]
            });
        });

        function confirmToggleStatus(id) {
            window.location.href = "{{ url('ManagePost') }}/" + id + "/toggleStatus";
        }

        // Back to Top Button Functionality
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            var backToTopBtn = document.getElementById("backToTopBtn");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTopBtn.style.display = "block";
            } else {
                backToTopBtn.style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
@endsection
