<!-- Table with DataTables integration -->
<table id="example" class="table table-hover">
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
                 <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">Edit</a>
                 <!-- Button to toggle user status -->
                 <a href="#" class="btn btn-sm {{ $user->is_active ? 'btn btn-outline-danger' : 'btn btn-outline-success' }}" onclick="showConfirmationModal('{{ route('users.toggleStatus', $user->id) }}', {{ $user->is_active }}, '{{ $user->name }}')">
                    {{ $user->is_active ? 'Deactivate' : 'Activate' }} <!-- Updated button label -->
                </a>

                <!-- Modal Toggle for Action Activate/Deactivate -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                            </div>
                            <div class="modal-body">
                                 Are you sure you want to <span id="actionVerb"></span> this "<span id="userName"></span>" user?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="cancelAction()">Cancel</button>
                                <a id="confirmActionBtn" href="#" class="btn btn-primary">Confirm<a>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <!-- Display Active or Inactive based on user's is_active status -->
                <span style="color: {{ $user->is_active ? 'green' : 'red' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </td>

            <td style="font-family: 'Bebas Neue', sans-serif; text-transform: uppercase;">{{ $user->role_as }}</td>
            {{-- <td>

            </td> --}}
        </tr>
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
                        <option value="user" {{ $user->type === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="business" {{ $user->type === 'business' ? 'selected' : '' }}>Business</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>


                {{-- <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div> --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="confirmActionBtn" class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#editConfirmationModal" onclick="showEditConfirmation('{{ route('users.update', $user->id) }}', '{{ $user->name }}')">Update</button>


                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach

<!-- Confirmation Modal -->
<div class="modal fade" id="editConfirmationModal" tabindex="-1" aria-labelledby="editConfirmationModalLabel" aria-hidden="true" data-form-id="editForm{{ $user->id }}">
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
          {{-- <button type="button" id="confirmEditButton" class="btn btn-primary">Confirm</button> --}}
          <!-- ConfirmButton -->
          <button type="button" id="confirmEditButton" class="btn btn-outline-warning" onclick="submitEditForm()">Confirm</button>
        </div>
      </div>
    </div>
  </div>



<script>
     function showConfirmationModal(route, isActive, userName) {
        // Set the action verb and user name in the modal
        document.getElementById('actionVerb').innerText = isActive ? 'deactivate' : 'activate';
        document.getElementById('userName').innerText = userName;

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

</script>




