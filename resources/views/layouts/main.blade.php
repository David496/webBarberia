<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="dark" data-sidebar="dark" data-sidebar-size="lg"
    data-layout-mode="light" data-sidebar-image="none">
{{-- <html lang="es" data-layout="vertical" data-layout-style="detached" data-sidebar="dark" data-topbar="dark" data-sidebar-size="lg" data-layout-mode="light" data-sidebar-image="none"> --}}
<head>

    <meta charset="utf-8" />
    <title>@yield('title') SWGRVB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="SWGRVB" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="{{ URL::asset('assets/images/racso/Favicon_new_racso.png') }}"> --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Sweet Alert css-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css" />

    <!-- Icons Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}" type="text/css" />

    <!-- App Css-->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}" type="text/css" />

    <!-- custom Css-->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css') }}" type="text/css" />

    {{-- <style>
        [data-layout=vertical] .layout-width {
            background: #212529;
            border-right: #212529;
        }

        [data-topbar=dark] .topbar-user {
            background-color: #313335;
        }

        [data-topbar=dark] #page-topbar {
            background-color: #212529;
            border-color: #212529;
        }

        [data-layout=vertical] #page-topbar {
            left: 0;
            border-bottom: 1px solid #212529;
        }

        .select2-container .select2-selection--single .select2-selection__clear {
            height: 36px;
            width: 35px;
            right: 2px;
            font-size: 1.3em;
            color: #ced4da;
        }

        .select2-dropdown {
            -webkit-box-shadow: 0 5px 10px rgba(56, 65, 74, 0.15);
            box-shadow: 0 5px 10px rgba(56, 65, 74, 0.15);
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 0.4rem .9rem;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            outline: none;
            border: 1px solid var(--vz-input-border);
            background-color: var(--vz-input-bg);
            color: var(--vz-body-color);
            border-radius: 0.25rem;
        }
    </style> --}}

    @yield('styles')
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="javascript:void(0);" class="logo logo-dark ">
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt=""
                                        height="35">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt=""
                                        height="35">
                                </span>
                            </a>

                            <a href="javascript:void(0);" class="logo logo-light "
                                style="line-height: 57px;">
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt=""
                                        height="35">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt=""
                                        height="35">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <div class=" d-md-block d-none" style="line-height: 72px;">
                            <span class="text-white text-nowrap">NOMBRE DE EMPRESA</span>
                        </div>

                    </div>

                    <div class="d-flex align-items-center">
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none"
                                onclick="fn_cambiar_tema()">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" id="id_fot_perf_header"
                                        src="{{ asset('assets/images/users/user-admin.svg') }}" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text text-lowercase text-capitalize">
                                            {{ Auth::user()->tipo_usuario }}
                                        </span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Bienvenido</h6>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Cerrar Sesión</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                {{-- <a href="{{ route('home_principal', $empresa->EMP_ID) }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/ICONOLARC2.png') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logolarc_light.png') }}" alt="" height="50">
                    </span>
                </a> --}}
                <!-- Light Logo-->
                {{-- <a href="{{ route('home_principal', $empresa->EMP_ID) }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/ICONOLARC2.png') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg ">
                        <img src="{{ asset('assets/images/logolarc_light.png') }}" class="my-4" alt=""
                            height="50">
                    </span>
                </a> --}}
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">ADMINISTRACION</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('home') }}">
                                <i class="las la-home"></i> <span data-key="t-widgets">Inicio</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('registroUsuarios')}}">
                                <i class="las la-user-alt"></i> <span data-key="t-widgets">Registro Usuarios</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#productoServicio" class="nav-link"
                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="productoServicio" data-key="t-projects"><i class="lab la-buffer"></i><span>Productos/Servicios</span>
                            </a>
                            <div class="collapse menu-dropdown" id="productoServicio">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="javascript:void(0);"
                                            class="nav-link" data-key="t-list"> Productos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0);"
                                            class="nav-link" data-key="t-list"> Servicios
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="javascript:void(0);">
                                <i class="las la-file-invoice-dollar"></i> <span data-key="t-widgets">Registro Ventas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="javascript:void(0);">
                                <i class="las la-book"></i> <span data-key="t-widgets">Registro Reservas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="javascript:void(0);">
                                <i class="las la-person-booth"></i> <span data-key="t-widgets">Registro Clientes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="javascript:void(0);">
                                <i class="las la-file-invoice"></i> <span data-key="t-widgets">Reportes de Venta</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="javascript:void(0);">
                                <i class="las la-tools"></i> <span data-key="t-widgets">Configuracion Empresa</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © SWGRVB
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Diseño & Desarrollo por Rodriguez Porras José David
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <script>
        var ruta_principal_main = "{{ asset('') }}" // declaras la ruta que apunta a public
    </script>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}

    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>
    <script type='text/javascript' src='{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('assets/libs/flatpickr/l10n/es.js') }}'></script>

    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- projects js -->
    {{-- <script src="{{ asset('assets/js/pages/dashboard-projects.init.js') }}"></script> --}}

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/l10n/es.js') }}"></script>
    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>
    <script src="{{ asset('assets/js/pages/select2.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function fn_cambiar_tema() {
            let theme_actual = sessionStorage.getItem('data-layout-mode');
            if (theme_actual == 'dark') {
                sessionStorage.setItem('data-layout-mode', 'light')
            } else {
                sessionStorage.setItem('data-layout-mode', 'dark')
            }
            console.log("funcion tema");
        }
    </script>
    <script>
        sessionStorage.setItem('data-layout', 'vertical')

        /** add active class and stay opened when selected */
        var url = window.location;
        // for sidebar menu entirely but not cover treeview
        $('ul.navbar-nav a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }


        }).addClass('active');

        // for treeview
        $('ul.nav-sm a').filter(function() {
            if (this.href) {
                return this.href == url || url.href.indexOf(this.href) == 0;
            }

        }).parentsUntil(".navbar-nav > .nav-sm").addClass('collapsed').prev('a').addClass('active');
    </script>
    @yield('scripts')

</body>

</html>
