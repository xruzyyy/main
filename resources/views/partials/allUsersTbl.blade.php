<!-- Table with DataTables integration -->
<table id="example" class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Business Name</th>
            <th scope="col">Business Email</th>
            <th scope="col">Permit</th>
            <th scope="col">Account Action</th>
            <th scope="col">Active Status</th>
            <th scope="col">Email Status</th>
            <th scope="col">Expiration Status</th>
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
                <!-- Edit Button -->
                <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal"
                    data-bs-target="#editModal{{ $user->id }}">Edit</a>
                <!-- Button to toggle user status -->
                <a href="#"
                    class="btn btn-sm {{ $user->is_active && $user->status && $user->status !== 3 ? 'btn-outline-danger' : 'btn-outline-success' }}"
                    data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $user->id }}">
                    {{ $user->is_active && $user->status && $user->status !== 3 ? 'Deactivate' : 'Activate' }}
                </a>
                      <!-- Button to trigger the rejection modal -->
        <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="showRejectionConfirmation('{{ route('users.reject', $user->id) }}', '{{ $user->name }}')">RESTRICT</button>

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
            <td>
                <!-- Display Active, Inactive, or Rejected based on user's status -->
                @if ($user->status == 1 && $user->is_active == 1)
                    <span style="color: green">Active</span>
                @elseif ($user->status == 0 && $user->is_active == 0)
                    <span style="color: red">Inactive</span>
                @else
                    <span style="color: red">Disable</span>
                @endif
            </td>
            <td style="font-family: 'Bebas Neue', sans-serif; text-transform: uppercase;">
                @if($user->email_verified_at != null)
                    {{ $user->email_verified_at }}
                @else
                    {{ 'Not Verified' }}
                @endif
            </td>

            <td style="font-family: 'Bebas Neue', sans-serif; text-transform: uppercase;">
                {{ $user->account_expiration_date }}
            </td>
        </tr>

        <!-- Rejection Modal -->
        <div class="modal fade" id="rejectConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="rejectConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectConfirmationModalLabel">Disable User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to submit rejection reason -->
                    <form id="rejectForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="rejectionReason">Reason for Disable</label>
                            <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary"
                        onclick="submitRejectionForm()">Disable</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        function showRejectionConfirmation(route, userName) {
            // Set the user name in the modal
            document.getElementById('rejectConfirmationModalLabel').innerText = 'Disable ' + userName;

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
        @endforeach
    </tbody>
</table>

<!-- Edit Modal -->
@foreach ($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="editForm{{ $user->id }}" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="user" {{ $user->type == 0 ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->type == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="business" {{ $user->type == 2 ? 'selected' : '' }}>Business</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="showEditConfirmation('{{ $user->id }}', '{{ $user->name }}')">Update</button>
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

<!-- Confirmation Modal -->
<div class="modal fade" id="editConfirmationModal" tabindex="-1" aria-labelledby="editConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editConfirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="editConfirmationMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmEditButton" class="btn btn-primary" onclick="submitEditForm()">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Status Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to <span id="actionVerb"></span> this "<span id="userName"></span>" user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="confirmActionBtn" href="#" class="btn btn-primary">Confirm</a>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>



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
        $('#confirmationModal').modal('hide');
    }

    function showEditConfirmation(userId, userName) {
        var confirmationMessage = "Are you sure you want to update user '" + userName + "'?";
        $("#editConfirmationMessage").text(confirmationMessage);
        $('#editConfirmationModal').modal('show');
        $('#confirmEditButton').attr('onclick', 'submitEditForm(' + userId + ')');
    }

    function submitEditForm(userId) {
        $('#editForm' + userId).submit();
        $('#editConfirmationModal').modal('hide');
    }

    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
