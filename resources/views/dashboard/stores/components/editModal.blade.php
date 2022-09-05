<div class="modal fade" id="editStoreModal_{{ $store->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> تحديث بيانات المتجر </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form action="{{ route('storesTable') }}" id="editStoreForm_{{ $store->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="storeId" value="{{ $store->id }}">
                    <div class="custom-form-field row">
                        <div class="form-group col-6">
                            <label for="name" class="mb"> اسم المتجر </label>
                            <input type="text" value="{{ $store->name }}" name="name" id="name" class="form-control" placeholder="ادخل اسم المتجر هنا">
                        </div>
                        <div class="form-group col-6">
                            <label for="categoryId" class="mb"> نوع المتجر </label>
                            <select id="categoryId" name="categoryId" class="form-control select2" data-toggle="select2">
                                <option value="{{ $store->categoryId }}" selected="selected"> {{ $store->category->name }} </option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label for="description"> وصف المتجر </label>
                            <textarea class="form-control" name="description" id="description" rows="6" placeholder="اكتب وصف تفصيلي عن المتجر">{{ $store->description }}</textarea>
                        </div>
                        <div class="form-group col-4">
                            <label for="logo" class="mb"> شعار المتجر </label>
                            <input type="file" name="logo" value="{{ $store->logo }}" id="logo" class="form-control" placeholder="اختار صورة  للمتجر">
                        </div>
                        <div class="form-group col-4">
                            <label for="rating" class="mb"> تقييم المتجر </label>
                            <input type="string" value="{{ $store->rating }}" name="rating" id="rating" class="form-control" placeholder="ادخل تقييم  المتجر">
                        </div>
                        <div class="form-group col-4">
                            <label for="offer" class="mb"> قيمة التخفيض </label>
                            <input type="number" value="{{ $store->offer }}" name="offer" id="offer" class="form-control" placeholder="ادخل تقييم  المتجر">
                        </div>

                        <div>
                            <label for="">تحديث موقع المتجر في الخريطة</label>
                            <input id="pac-input"  name="address" class="controls form-control" type="text" placeholder="ابحث عن المتجر" />
                            <div id="map"></div>
                        </div>
>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" name="editStoreBtn" form="editStoreForm_{{ $store->id }}" class="btn btn-primary"> حفظ التعديلات </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>

