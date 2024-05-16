<!-- Modals -->
@foreach ($users as $user)
<div class="modal fade" id="imageModal{{ $user->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display the larger image -->
                <div class="image-container">
                    <img src="{{ asset($user->image) }}" class="img-fluid" alt="" id="zoomedImage">
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach