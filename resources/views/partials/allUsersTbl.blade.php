<!-- Table with DataTables integration -->
<table id="example" class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Business Email</th>
            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
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
                <a href="{{ route('users.toggleStatus', $user->id) }}" class="btn btn-sm btn-{{ $user->status ? 'success' : 'danger' }}">
                    {{ $user->status ? 'Enable' : 'Disable' }}
                </a>
            </td>

            <td>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
