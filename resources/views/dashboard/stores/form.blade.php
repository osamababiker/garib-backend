@include('dashboard/components/header')

<body data-theme="default" data-layout="fluid" data-sidebar-position="right" data-sidebar-behavior="sticky">
    <div class="wrapper">

        @include('dashboard/components/sidebar')

        <main class="content">
            <div class="container-fluid p-0">

                <div class="row mb-2 mb-xl-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3>لوحة التحكم</h3>
                    </div>

                    <div class="col-auto ms-auto text-end mt-n1">
                        <span class="dropdown me-2">
                            <button class="btn btn-light bg-white shadow-sm dropdown-toggle" id="day" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="align-middle mt-n1" data-feather="calendar"></i> اليوم
                            </button>
                        </span>

                        <button class="btn btn-primary shadow-sm">
                            <i class="align-middle" data-feather="filter">&nbsp;</i>
                        </button>
                        <button class="btn btn-primary shadow-sm">
                            <i class="align-middle" data-feather="refresh-cw">&nbsp;</i>
                        </button>
                    </div>
                </div>

                @if(session()->has('storeCreated'))
                    <div class="alert alert-success alert-dismissible" id="successAlert"  role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <strong> اهلا {{ Auth::user()->name }} </strong> {{session()->get('storeCreated')}}
                        </div>
                    </div>
                @endif

                @if(session()->has('errors'))
                    <div class="alert alert-danger alert-dismissible" id="successAlert"  role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <strong> اهلا {{ Auth::user()->name }} </strong> {{session()->get('errors')}}
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12 col-lg-12 d-flex">
                        <div class="card flex-fill w-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0"> اضافة متجر جديد </h5>
                            </div>
                            <div class="card-body d-flex w-100">
                                <form action="{{ route('storesForm') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="custom-form-field row">
                                        <div class="form-group col-6">
                                            <label for="name" class="mb"> اسم المتجر </label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="ادخل اسم المتجر هنا">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="categoryId" class="mb"> نوع المتجر </label>
                                            <select id="categoryId" name="categoryId" class="form-control select2" data-toggle="select2">
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="description"> وصف المتجر </label>
                                            <textarea class="form-control" name="description" id="description" rows="6" placeholder="اكتب وصف تفصيلي عن المتجر"></textarea>
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="logo" class="mb"> شعار المتجر </label>
                                            <input type="file" name="logo" id="logo" class="form-control" placeholder="ارفق صورة  للمتجر">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="rating" class="mb"> تقييم المتجر </label>
                                            <input type="string" name="rating" id="rating" class="form-control" placeholder="ادخل تقييم  المتجر">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="offer" class="mb"> قيمة التخفيض </label>
                                            <input type="number" name="offer" id="offer" class="form-control" placeholder="ادخل تقييم  المتجر">
                                        </div>

                                        <div>
                                            <label for="">موقع المتجر في الخريطة</label>
                                            <input id="pac-input" name="address" class="controls form-control" type="text" placeholder="ابحث عن المتجر" />
                                            <div id="map"></div>
                                        </div>

                                        <div class="form-group col-12">
                                            <label for=""></label>
                                            <button type="submit" name="saveStoreBtn" class="btn btn-primary"> اضافة المتجر </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
        <script
        src="https://maps.googleapis.com/maps/api/js?key={{$key}}&callback=initAutocomplete&libraries=places&v=weekly"
        async
        ></script>

        <script>
            function initAutocomplete() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 15.500654, lng: 32.559898 },
                zoom: 13,
                mapTypeId: "roadmap",
            });
            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };
                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                    map,
                    icon,
                    title: place.name,
                    position: place.geometry.location,
                    })
                );

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                });
                map.fitBounds(bounds);
            });
            }

        </script>
        @include('dashboard/components/footer')
