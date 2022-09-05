@include('dashboard/components/header')

<body data-theme="default" data-layout="fluid" data-sidebar-position="right" data-sidebar-behavior="sticky">
    <div class="wrapper">

        @include('dashboard/components/sidebar')

        <div class="main">

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"> جدول ادارة المستخدمين </h1>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> ادارة المستخدمين </h5>
                                    <h6 class="card-subtitle text-muted"> بمقدورك مراقبة بيانات المستخدمين على التطبيق </h6>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>اسم المستخدم</th>
                                                <th> الايميل</th>
                                                <th>رقم الهاتف</th>
                                                <th>العنوان</th>
                                                <th>الموقع في الخريطة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->address }}</td>
                                                <td>
                                                <a class="btn" style="background-color: #fff; border: 1px solid #000" href="javascript::void()" data-bs-toggle="modal" data-bs-target="#locationModal_{{ $user->id }}">
                                                    اعرض
                                                </a>
                                                </td>
                                            </tr>
                                            <!-- user location modal -->
                                            @include('dashboard/users/components/locationModal');
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>



            <script src="https://maps.googleapis.com/maps/api/js?key={{$key}}&callback=initMap&libraries=&v=weekly" async></script>

            @include('dashboard/components/footer')
