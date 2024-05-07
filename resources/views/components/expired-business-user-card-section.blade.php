<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="background-color: rgb(218, 32, 32)">
                Expired Accounts
            </div>
            <div class="card-body overflow-auto" style="background-color: rgba(0, 0, 0, 0.2)"> <!-- Added overflow-auto class here -->
                <table id="expiredAccountsTable" class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Expiration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expiredAccounts as $account)
                            <tr>
                                <td>{{ $account->id }}</td>
                                <td>
                                    <!-- Add a container div for the circular image -->
                                    <div class="rounded-image-container">
                                        <!-- Add class "rounded-image" to apply CSS -->
                                        <img class="rounded-image" src="{{ asset($account->image) }}" alt="">
                                    </div>
                                </td>
                                <td>{{ $account->name }}</td>
                                <td>{{ $account->email }}</td>
                                <td>{{ $account->account_expiration_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom CSS for the expired accounts table */

    .rounded-image-container {
        width: 40px;
        height: 40px;
        overflow: hidden;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.2); /* Optional: Add a background color */
    }

    .rounded-image {
        width: 100%;
        height: 100%;
        border-radius: 50%;
    }
    #expiredAccountsTable_wrapper {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #expiredAccountsTable_length label {
        font-weight: bold;
    }

    #expiredAccountsTable_filter input {
        border: 1px solid #ccc;
        border-radius: 20px;
        padding: 8px 15px;
        transition: border-color 0.3s ease;
    }

    #expiredAccountsTable_filter input:focus {
        border-color: #007bff;
        outline: none;
    }

    #expiredAccountsTable_paginate .paginate_button {
        padding: 8px 15px;
        margin: 0 5px;
        border-radius: 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        transition: background-color 0.3s ease;
    }

    #expiredAccountsTable_paginate .paginate_button:hover {
        background-color: #0056b3;
    }

    #expiredAccountsTable_paginate .paginate_button.disabled {
        background-color: #6c757d;
    }

    #expiredAccountsTable_paginate .paginate_button.current {
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


<!-- Include jQuery and DataTables JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        var defaultLimit = {{ request()->input('limit' , 5) }};
        // DataTable initialization
        $('#expiredAccountsTable').DataTable({
            "dom": '<"d-flex justify-content-between align-items-center"Bf><"clear">lirtp',
            "lengthMenu": [[5, 10, 20, 50, 100, -1], [5, 10, 20, 50, 100, "All"]],
            "paging": true,
            "autoWidth": true,
            "buttons": [

            ]
        });
    });
</script>
