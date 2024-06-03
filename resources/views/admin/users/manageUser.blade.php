@extends('layouts.master')

@section('content-user')
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <h1>Users List</h1>



    <thead class="thead-dark">
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Include jQuery and DataTables JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center"Bf><"clear">lirtp',
            "paging": true,
            "autoWidth": true,
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

    /* Custom CSS for the DataTables links */
    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px; /* Added margin */
    }
</style>
@endsection
