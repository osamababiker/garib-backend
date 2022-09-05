@include('dashboard/components/header')

<body data-theme="default" data-layout="fluid" data-sidebar-position="right" data-sidebar-behavior="sticky">
    <div class="wrapper">

        @include('dashboard/components/sidebar')

        <div class="main">

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"> جدول ادارة عروض التوصيل </h1>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> ادارة عروض التوصيل </h5>
                                    <h6 class="card-subtitle text-muted"> بمقدورك متابعة عروض التوصيل  </h6>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th> اسم المندوب </th>
                                                <th>اسم العميل</th>
                                                <th> الطلب</th>
                                                <th>حالة العرض</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($offers as $offer)
                                            <tr>
                                                <td>{{ $offer->driver->name }}</td>
                                                <td>{{ $offer->customer->name }}</td>
                                                <td>{{ $offer->order->order }}</td>
                                                <td>
                                                    @if($offer->status == 0)
                                                    <span> <i class="fa fa-times" style="color: red"></i> </span>
                                                    @elseif($offer->status == 1)
                                                    <span>  <i class="fa fa-check" style="color: green"></i> </span>
                                                    @endif
                                                </td>
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
