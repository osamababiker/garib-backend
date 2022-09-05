<div class="modal fade" id="deletePlaintModal_{{ $plaint->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">  حذف الشكوي </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <p class="mb-0"> هل انت متأكد من رغبتك في حذف هذه الشكوي  </p>
                <form action="{{ route('plaintsTable') }}" id="deletePlaintForm_{{ $plaint->id }}" method="POST">
                    @csrf
                    <input type="hidden" name="plaintId" value="{{ $plaint->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" name="deleteBtn" form="deletePlaintForm_{{ $plaint->id }}" class="btn btn-warning"> نعم متأكد </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>
