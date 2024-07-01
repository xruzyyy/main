@extends('layouts.master')

@section('content-business')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary">
                    <h3 class="text-gold mb-0">Business User Management</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="btn-group" role="group">
                                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="show-not-expired">
                                    <button type="submit" class="btn btn-outline-primary me-2">Active Users</button>
                                </form>
                                <form id="manageBusinessForm" action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="show-expired-list">
                                    <button type="submit" class="btn btn-outline-warning me-2">Pending To Disable</button>
                                </form>
                                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="show-inactive-list">
                                    <button type="submit" class="btn btn-outline-secondary me-2">Inactive Users</button>
                                </form>
                                <form action="{{ route('manageBusiness') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="show-rejected-list">
                                    <button type="submit" class="btn btn-outline-danger">Disabled Users</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="userTable" class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Expiration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($activeUsersData))
                                    @foreach ($activeUsersData as $userData)
                                        <tr>
                                            <td>{{ $userData->id }}</td>
                                            <td>{{ $userData->name }}</td>
                                            <td>{{ $userData->email }}</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>{{ $userData->account_expiration_date }}</td>
                                        </tr>
                                    @endforeach
                                @elseif(isset($expiredUsersData))
                                    @foreach ($expiredUsersData as $userData)
                                        <tr>
                                            <td>{{ $userData->id }}</td>
                                            <td>{{ $userData->name }}</td>
                                            <td>{{ $userData->email }}</td>
                                            <td><span class="badge bg-warning text-dark">Pending Disable</span></td>
                                            <td>{{ $userData->account_expiration_date }}</td>
                                        </tr>
                                    @endforeach
                                @elseif(isset($inactiveUsersData))
                                    @foreach ($inactiveUsersData as $userData)
                                        <tr>
                                            <td>{{ $userData->id }}</td>
                                            <td>{{ $userData->name }}</td>
                                            <td>{{ $userData->email }}</td>
                                            <td><span class="badge bg-secondary">Inactive</span></td>
                                            <td>{{ $userData->account_expiration_date }}</td>
                                        </tr>
                                    @endforeach
                                @elseif(isset($rejectedUsersData))
                                    @foreach ($rejectedUsersData as $userData)
                                        <tr>
                                            <td>{{ $userData->id }}</td>
                                            <td>{{ $userData->name }}</td>
                                            <td>{{ $userData->email }}</td>
                                            <td><span class="badge bg-danger">Disabled</span></td>
                                            <td>{{ $userData->account_expiration_date }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
<style>
    .card {
        border: none;
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    .btn-group .btn {
        border-radius: 20px;
    }
    .table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
    }
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    /* Override DataTables buttons styles */
    .dt-buttons .btn-outline-primary {
        color: #007bff !important; /* Text color */
        border-color: #007bff !important; /* Border color */
    }

    .dt-buttons .btn-outline-primary:hover {
        background-color: #007bff !important; /* Hover background color */
        color: #fff !important; /* Hover text color */
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        dom: '<"row"<"col-md-6"B><"col-md-6"f>>rtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: ['copy', 'excel', 'csv', 'pdf', 'print']
            },
            'colvis'
        ],
        pageLength: 10,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Search users..."
        }
    });

    $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-outline-primary');
    $('.dataTables_filter input').addClass('form-control-sm');
});
</script>
@endsection
