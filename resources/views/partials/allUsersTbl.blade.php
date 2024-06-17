<!-- Table with DataTables integration -->
<table id="example" class="table ">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Business Email</th>
            <th scope="col">Permit</th>
            <th scope="col">Account Action</th>
            <th scope="col">Active Status</th> <!-- Updated column header -->
            <th scope="col">Role As</th>
            {{-- <th scope="col">Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            @if ($user->type === 'business')
                <!-- Check if the user type is 'business' -->

                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <!-- Define the modal structure with modal-lg class -->
                    <div class="modal fade" id="imageModal{{ $user->id }}" tabindex="-1"
                        aria-labelledby="imageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Display the larger version of the image -->
                                    <img src="{{ asset($user->image) }}" class="img-fluid" alt="Image Preview">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Link to trigger the modal -->
                    <td>
                        <a href="#" class="image-preview" data-bs-toggle="modal"
                            data-bs-target="#imageModal{{ $user->id }}">
                            <img src="{{ asset($user->image) }}" style="width: 70px; height: 70px;" alt="Thumbnail">
                        </a>
                    </td>

                    <td>
                        <!-- Edit Button -->
                        <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $user->id }}">Edit</a>
                        <!-- Button to toggle user status -->
                        <a href="#"
                            class="btn btn-sm {{ $user->is_active && $user->status && $user->status !== 3 ? 'btn-outline-danger' : 'btn-outline-success' }}"
                            data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $user->id }}">
                            {{ $user->is_active && $user->status && $user->status !== 3 ? 'Deactivate' : 'Activate' }}
                        </a>

                        <!-- Modal Toggle for Action Activate/Deactivate -->
                        <div class="modal fade" id="confirmationModal{{ $user->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="confirmationModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel{{ $user->id }}">
                                            Confirmation</h5>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to
                                        <span>{{ $user->is_active && $user->status ? 'deactivate' : 'activate' }}</span>
                                        the user "<span>{{ $user->name }}</span>"?
                                        <!-- Date picker for account expiration date -->
                                        <form id="toggleStatusForm{{ $user->id }}"
                                            action="{{ route('users.toggleStatus', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="account_expiration_date{{ $user->id }}">Account
                                                    Expiration Date</label>
                                                <input type="date" name="account_expiration_date"
                                                    id="account_expiration_date{{ $user->id }}"
                                                    class="form-control"
                                                    value="{{ $user->account_expiration_date ? \Carbon\Carbon::parse($user->account_expiration_date)->format('Y-m-d') : '' }}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="document.getElementById('toggleStatusForm{{ $user->id }}').submit();">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>


                    <!-- Modal for image preview -->
                    <div class="modal fade" id="imageModal{{ $user->id }}" tabindex="-1"
                        aria-labelledby="imageModalLabel" aria-hidden="true" style="z-index: 9999;">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $user->image) }}" class="card-img-top"
                                            alt="Business Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <td>
                        <!-- Display Active, Inactive, or Rejected based on user's status -->
                        @if ($user->status == 1 && $user->is_active == 1)
                            <span style="color: green">Active</span>
                        @elseif ($user->status == 0 && $user->is_active == 0)
                            <span style="color: red">Inactive</span>
                        @else
                            <span style="color: red">Rejected</span>
                        @endif
                    </td>


                    <td style="font-family: 'Bebas Neue', sans-serif; text-transform: uppercase;">{{ $user->role_as }}
                    </td>
                    <!-- Rejection Modal -->
                    <div class="modal fade" id="rejectConfirmationModal" tabindex="-1" role="dialog"
                        aria-labelledby="rejectConfirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rejectConfirmationModalLabel">Reject User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form to submit rejection reason -->
                                    <form id="rejectForm" action="" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="rejectionReason">Reason for Rejection</label>
                                            <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="submitRejectionForm()">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Update your table markup to include a button that triggers the rejection modal -->
                    <td>
                        <!-- Button to trigger the rejection modal -->
                        <button type="button" class="btn btn-outline-danger"
                            onclick="showRejectionConfirmation('{{ route('users.reject', $user->id) }}', '{{ $user->name }}')">Reject</button>
                    </td>

                    <script>
                        function showRejectionConfirmation(route, userName) {
                            // Set the user name in the modal
                            document.getElementById('rejectConfirmationModalLabel').innerText = 'Reject ' + userName;

                            // Set the route for the form action
                            document.getElementById('rejectForm').setAttribute('action', route);

                            // Show the modal
                            $('#rejectConfirmationModal').modal('show');
                        }

                        function submitRejectionForm() {
                            // Submit the rejection form
                            document.getElementById('rejectForm').submit();
                        }
                    </script>

                </tr>
            @endif
        @endforeach
    </tbody>
</table>



<!-- Edit Modal -->
@foreach ($users as $user)
    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
        aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="editForm{{ $user->id }}" action="{{ route('users.update', $user->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $user->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="user" {{ $user->type === 'user' ? 'selected' : '' }}>User
                                    </option>
                                    <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="business" {{ $user->type === 'business' ? 'selected' : '' }}>
                                        Business</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="account_expiration_date">Account Expiration Date</label>
                                <input type="date" name="account_expiration_date" id="account_expiration_date"
                                    class="form-control"
                                    value="{{ $user->account_expiration_date ? \Carbon\Carbon::parse($user->account_expiration_date)->format('Y-m-d') : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1_1"
                                        {{ $user->status == 1 && $user->is_active == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0_0"
                                        {{ $user->status == 0 && $user->is_active == 0 ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            <!-- Image upload field -->
                            <div class="form-group">
                                <label for="image">Permit Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @if ($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image"
                                        style="width: 100px; height: 100px; margin-top: 10px;">
                                @endif
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button id="confirmActionBtn" class="btn btn-outline-primary"
                                    type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach



@foreach ($users as $user)
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to <span id="actionVerb"></span> this "<span id="userName"></span>" user?
                    <form id="toggleStatusForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="account_expiration_date">Account Expiration Date</label>
                            <input type="date" name="account_expiration_date" id="account_expiration_date"
                                class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="cancelAction()">Cancel</button>
                    <button type="submit" class="btn btn-primary"
                        onclick="submitToggleStatusForm()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endforeach


<script>
    $(document).ready(function() {
        // Initialize the date picker
        $('#account_expiration_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });


    function showConfirmationModal(route, isActive, userName) {
        // Set the action verb and user name in the modal
        document.getElementById('actionVerb').innerText = isActive ? 'deactivate' : 'activate';
        document.getElementById('userName').innerText = userName;

        // Get the account expiration date value from the input field
        var accountExpirationDate = document.getElementById('account_expiration_date').value;
        console.log('Account Expiration Date:', accountExpirationDate); //   Debugging statement

        // Set the route for the action button
        document.getElementById('confirmActionBtn').setAttribute('href', route);

        // Show the modal
        $('#confirmationModal').modal('show');
    }


    function cancelAction() {
        // Hide the modal
        $('#confirmationModal').modal('hide');
    }

    function showEditConfirmation(route, userName) {
        var confirmationMessage = "Are you sure you want to update user '" + userName + "'?";
        $("#editConfirmationMessage").text(confirmationMessage);

        // Show the confirmation modal
        $('#editConfirmationModal').modal('show');
    }

    function submitEditForm() {
        var formId = $('#editConfirmationModal').data('form-id');
        $('#' + formId).submit();
        $('#editConfirmationModal').modal('hide');
    }

    $(document).ready(function() {
        // Get the current limit parameter from the URL
        var defaultLimit = {{ request()->input('limit', 10) }};
        // Get the current sort parameter from the URL
        var defaultSort = "{{ request()->input('sort', 'newest') }}";

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
                    extend: 'excelHtml5',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-secondary'
                },

            ]
        });


        // Set the default sorting
        table.order([0, defaultSort === 'newest' ? 'desc' : 'asc']).draw();

        // Listen for click events on pagination links
        $('.pagination').on('click', 'a.page-link', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');

            // Check if the URL contains the 'limit=all' parameter
            if (url.includes('limit=all')) {
                // If 'limit=all' is present, remove the 'sort' and 'filter' parameters while preserving the search parameter
                var searchParam = getURLParameter('search'); // Get the search parameter
                if (searchParam !== null) {
                    // If search parameter exists, append it to the URL
                    url = url + '&search=' + searchParam;
                }
                url = removeURLParameter(url, 'sort');
                url = removeURLParameter(url, 'filter');
            }

            // Redirect to the modified URL
            window.location.href = url;
        });

        // Function to remove a parameter from the URL
        function removeURLParameter(url, parameter) {
            // Create a pattern to match the parameter and its value in the URL
            var pattern = new RegExp('([&?])' + parameter + '=[^&]*&?');

            // Replace the matched pattern with an empty string
            url = url.replace(pattern, '$1');

            // Remove any trailing '&' if present
            url = url.replace(/[&]$/, '');

            return url;
        }

        // Function to get a parameter value from the URL
        function getURLParameter(name) {
            // Get the URL parameters
            var params = new URLSearchParams(window.location.search);
            // Return the value of the parameter with the specified name
            return params.get(name);
        }
    });
</script>
