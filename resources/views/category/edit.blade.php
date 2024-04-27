@extends('layouts.master')

@section('ManagePostEdit')
<div class="container mx-auto p-5">
    <div class="row">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Edit Business
                        <a href="{{ url('ManagePost') }}" class="btn btn-primary float-end">Back</a>
                    </h4>
                </div>

                <div class="card-body">
                    <form id="updateForm" action="{{ url('ManagePost/'.$category->id.'/edit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Name:</label>
                            <input type="text" name="businessName" value="{{ old('businessName',$category->businessName) }}">
                            @error('businessName') <span class="text-danger"> {{ $message }} </span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Description:</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description') <span class="text-danger"> {{ $message }} </span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Is Active</label>
                            <input type="checkbox" name="is_active" {{ $category->is_active ? 'checked' : '' }} />
                            @error('is_active') <span class="text-danger"> {{ $message }} </span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Upload Business Permit</label>
                            <input type="file" name="image" class="form-control" value={{old('businessName')}}>
                            @error('image') <span class="text-danger"> {{ $message }} </span>  @enderror

                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to update this business?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmUpdateBtn">Confirm Update</button>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- JavaScript for Delete Confirmation -->
@section('scriptsEdit')

<script>
    document.getElementById("confirmUpdateBtn").addEventListener("click", function () {
        document.getElementById("updateForm").submit();
    });
</script>

@endsection
