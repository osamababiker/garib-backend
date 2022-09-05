<div class="modal fade" id="editPlaintModal_{{ $plaint->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> اغلاق  الشكوي </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
            <form action="{{ route('plaintsTable') }}" id="editPlaintForm_{{ $plaint->id }}"" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="plaintId" value="{{ $plaint->id }}">
                <div class="custom-form-field row">
                    <div class="form-group col-6">
                        <label for="isClosed" class="mb"> حالة  الشكوي </label>
                        <select name="isClosed" id="isClosed" class="form-control">
                            <option value="1">تم الاغلاق</option>
                            <option value="0">لم يتم الاغلاق</option>
                        </select>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="submit" name="editBtn" form="editPlaintForm_{{ $plaint->id }}" class="btn btn-primary"> حفظ التعديلات </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>

