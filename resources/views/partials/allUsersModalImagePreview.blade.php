<!-- Modals -->
@foreach ($users as $user)
<!-- Define the modal structure -->
<div class="modal fade" id="imageModal{{ $user->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display the larger version of the image -->
                <img src="{{ asset($user->image) }}" class="img-fluid" alt="Image Preview">
            </div>
        </div>
    </div>
</div>

@endforeach
