@include('dashboard/components/header')

<body data-theme="default" data-layout="fluid" data-sidebar-position="right" data-sidebar-behavior="sticky">
    <div class="wrapper">

        @include('dashboard/components/sidebar')

        <div class="main">

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"> جدول ادارة الطلبات </h1>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> ادارة الطلبات </h5>
                                    <h6 class="card-subtitle text-muted"> بمقدورك متابعة طلبات العملاء </h6>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>اسم المتجر</th>
                                                <th>اسم العميل</th>
                                                <th> الطلب</th>
                                                <th>حالة الطلب</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $order->store->name }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->order }}</td>
                                                <td>
                                                    @if($order->status == 0)
                                                    <p style="color: #000"> استقبال العروض </p>
                                                    @elseif($order->status == 1)
                                                    <p style="color: #000"> جاري التوصيل </p>
                                                    @elseif($order->status == 2)
                                                    <p style="color: #000"> تم التوصيل </p>
                                                    @elseif($order->status == 3)
                                                    <p style="color: #000"> تم الالغاء </p>
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
