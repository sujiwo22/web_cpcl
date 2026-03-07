<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CPCL - Sumatera Barat') }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
    <script src="https://cdn.jsdelivr.net"></script>
</head>

<body class="hold-transition sidebar-mini">
    {{-- <div id="app"> --}}
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                @include('menu.main_menu')
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <main class="py-4">
                @yield('content')
            </main>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>
    {{-- </div> --}}
</body>
{{-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script>
    function list_provinsi(object, hasil = null) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = "{{ route('provinsi.list') }}";
        // url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            before: function() {
                $('#' + object).empty();
                $('#' + object).append('<option value="">Wait...</option>')
            },
            success: function(data) {
                $('#' + object).empty();
                $('#' + object).append('<option value="">[Please Select]</option>')
                $.each(data, function(key, value) {
                    if (hasil != null) {
                        if (hasil == value.id_provinsi) {
                            $('#' + object).append('<option value="' + value.id_provinsi + '" selected>' +
                                value.nama_provinsi +
                                '</option>');
                        } else {
                            $('#' + object).append('<option value="' + value.id_provinsi + '">' + value
                                .nama_provinsi +
                                '</option>');
                        }
                    } else {
                        $('#' + object).append('<option value="' + value.id_provinsi + '">' + value
                            .nama_provinsi +
                            '</option>');
                    }
                });
            },
            error: function(response) {
                $('#' + object).empty();
            }
        });
    };
    
    function list_kota(object,id_provinsi, hasil = null) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = "{{ route('kota.list',':id') }}";
        url = url.replace(':id', id_provinsi);
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            before: function() {
                $('#' + object).empty();
                $('#' + object).append('<option value="">Wait...</option>')
            },
            success: function(data) {
                $('#' + object).empty();
                $('#' + object).append('<option value="">[Please Select]</option>')
                $.each(data, function(key, value) {
                    if (hasil != null) {
                        if (hasil == value.id_kota) {
                            $('#' + object).append('<option value="' + value.id_kota + '" selected>' +
                                value.nama_kota +
                                '</option>');
                        } else {
                            $('#' + object).append('<option value="' + value.id_kota + '">' + value
                                .nama_kota +
                                '</option>');
                        }
                    } else {
                        $('#' + object).append('<option value="' + value.id_kota + '">' + value
                            .nama_kota +
                            '</option>');
                    }
                });
            },
            error: function(response) {
                $('#' + object).empty();
            }
        });
    };
    
    function list_kecamatan(object,id_kota, hasil = null) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = "{{ route('kecamatan.list',':id') }}";
        url = url.replace(':id', id_kota);
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            before: function() {
                $('#' + object).empty();
                $('#' + object).append('<option value="">Wait...</option>')
            },
            success: function(data) {
                $('#' + object).empty();
                $('#' + object).append('<option value="">[Please Select]</option>')
                $.each(data, function(key, value) {
                    if (hasil != null) {
                        if (hasil == value.id_kecamatan) {
                            $('#' + object).append('<option value="' + value.id_kecamatan + '" selected>' +
                                value.nama_kecamatan +
                                '</option>');
                        } else {
                            $('#' + object).append('<option value="' + value.id_kecamatan + '">' + value
                                .nama_kecamatan +
                                '</option>');
                        }
                    } else {
                        $('#' + object).append('<option value="' + value.id_kecamatan + '">' + value
                            .nama_kecamatan +
                            '</option>');
                    }
                });
            },
            error: function(response) {
                $('#' + object).empty();
            }
        });
    };
</script>
@yield('javascript')

</html>