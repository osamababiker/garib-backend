@include('dashboard/components/header')

<body data-theme="default" data-layout="fluid" data-sidebar-position="right" data-sidebar-behavior="sticky">
    <div class="wrapper">

        @include('dashboard/components/sidebar')

        <div class="main">

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"> جدول ادارة المتاجر </h1>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> ادارة المتاجر </h5>
                                    <h6 class="card-subtitle text-muted"> بمقدورك التعديل على بيانات المتجر وصوره في التطبيق او حتى حذفه </h6>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>اسم المتجر</th>
                                                <th>الفئة</th>
                                                <th> التقييم</th>
                                                <th>قيمة التخفيض</th>
                                                <th> الوصف </th>
                                                <th>صورة المتجر</th>
                                                <th>ادارة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stores as $store)
                                            <tr>
                                                <td>{{ $store->name }}</td>
                                                <td>{{ $store->category->name }}</td>
                                                <td>{{ $store->rating }}</td>
                                                <td>{{ $store->offer }} %</td>
                                                <td>
                                                <a class="btn" style="background-color: #fff; border: 1px solid #000" href="javascript::void()" data-bs-toggle="modal" data-bs-target="#descriptionModal_{{ $store->id }}">
                                                    اعرض
                                                </a>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{ asset('upload/stores/'.$store->logo) }}">
                                                        <img src="{{ asset('upload/stores/'.$store->logo) }}" width="100" height="100" alt="">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript::void()" data-bs-toggle="modal" data-bs-target="#deleteStoreModal_{{ $store->id }}"  style="color: red;"> <i class="fa fa-trash"></i> </a>
                                                    &nbsp;
                                                    <a href="javascript::void()" data-bs-toggle="modal" data-bs-target="#editStoreModal_{{ $store->id }}"> <i class="fa fa-edit"></i> </a>
                                                </td>
                                            </tr>
                                            <!-- to edit store info --->
                                            @include('dashboard/stores/components/editModal');
                                            <!-- to delete store -->
                                            @include('dashboard/stores/components/deleteModal');
                                            <!-- to show store description store -->
                                            @include('dashboard/stores/components/descriptionModal');
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @include('dashboard/components/footer')
