<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">
    <title>قريب - تسجيل دخول</title>
    <link rel="shortcut icon" href="img/favicon.ico">

    <link class="js-stylesheet" href="{{ asset('dashboard/css/ar-light.css') }}" rel="stylesheet">
    <link class="js-stylesheet" href="{{ asset('dashboard/css/custom.css') }}" rel="stylesheet">
</head>


<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
    <div class="main d-flex justify-content-center w-100">
        <main class="content d-flex p-0">
            <div class="container d-flex flex-column">
                <div class="row h-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                        <div class="d-table-cell align-middle">

                            <div class="text-center mt-4">
                                <h1 class="h2"> قريب لخدمات التوصيل  </h1>
                                <p class="lead">
                                    الرجاء قراء سياسة الاستخدام والخصوصية الخاصة بالتطبيق
                                </p>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="m-sm-4">
                                        <p> {{ \App\Models\Setting::first()->policy }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/app.js"></script>

</body>

</html>
