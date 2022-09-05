@include('dashboard/components/header')

<body data-theme="default" data-layout="fluid" data-sidebar-position="right" data-sidebar-behavior="sticky">
    <div class="wrapper">

        @include('dashboard/components/sidebar')

        <div class="main">

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"> جدول ادارة الشكاوي والمقترحات </h1>
                    
                    @if(session()->has('plaintClosed'))
                        <div class="alert alert-success alert-dismissible" id="successAlert"  role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-message">
                                <strong> اهلا {{ Auth::user()->name }} </strong> {{session()->get('plaintClosed')}}
                            </div>
                        </div>
                    @endif

                    @if(session()->has('plaintDeleted'))
                        <div class="alert alert-success alert-dismissible" id="successAlert"  role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-message">
                                <strong> اهلا {{ Auth::user()->name }} </strong> {{session()->get('plaintDeleted')}}
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> ادارة الشكاوي والمقترحات </h5>
                                    <h6 class="card-subtitle text-muted"> بمقدورك متابعة شكاوي ومقترحات العملاء </h6>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>اسم العميل</th>
                                                <th>رقم العميل</th>
                                                <th> السكن</th>
                                                <th> الشكوي </th>
                                                <th>حالة الشكوي</th>
                                                <th> ادارة </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($plaints as $plaint)
                                            <tr>
                                                <td>{{ $plaint->user->name }}</td>
                                                <td>{{ $plaint->user->phone }}</td>
                                                <td>{{ $plaint->user->address }}</td>
                                                <td>{{ $plaint->plaint }}</td>
                                                <td>
                                                    @if($plaint->isClosed == 0)
                                                        <i class="fa fa-times" style="color: red"></i>
                                                    @else 
                                                        <i class="fa fa-check" style="color: green"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="javascript::void()" data-bs-toggle="modal" data-bs-target="#deletePlaintModal_{{ $plaint->id }}"  style="color: red;"> <i class="fa fa-trash"></i> </a>
                                                    &nbsp;
                                                    <a href="javascript::void()" data-bs-toggle="modal" data-bs-target="#editPlaintModal_{{ $plaint->id }}"> <i class="fa fa-edit"></i> </a>
                                                </td>
                                                <!-- to edit plaints info --->
                                                @include('dashboard/plaints/components/editModal');
                                                <!-- to delete plaints -->
                                                @include('dashboard/plaints/components/deleteModal');
                                            </tr>
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
