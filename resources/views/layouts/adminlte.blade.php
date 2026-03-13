<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- ===================== NAVBAR ===================== -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <!-- Left navbar -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <!-- Right navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Fullscreen -->
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn nav-link" type="submit">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </li>

        </ul>
    </nav>
    <!-- ===================== /NAVBAR ===================== -->

    <!-- ===================== SIDEBAR ===================== -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}"
                class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">CIM Stages</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            @php
                $roleName = auth()->user()->role->name ?? 'stagiaire';
            @endphp

            @if($roleName === 'admin')
                @include('layouts.partials.sidebar-admin')

            @elseif($roleName === 'agent')
                @include('layouts.partials.sidebar-agent')

            @elseif($roleName === 'responsable')
                @include('layouts.partials.sidebar-responsable')

            @elseif($roleName === 'darh')
                @include('layouts.partials.sidebar-darh')

            @else
                @include('layouts.partials.sidebar-stagiaire')
            @endif


        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- ===================== /SIDEBAR ===================== -->

    <!-- ===================== CONTENT ===================== -->
    <div class="content-wrapper">

        <!-- Page header (optionnel) -->
        <section class="content-header">
            <div class="container-fluid">
                <h1>@yield('page-title')</h1>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>

    </div>
    <!-- ===================== /CONTENT ===================== -->

</div>
<!-- ./wrapper -->

<!-- ===================== SCRIPTS ===================== -->
<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- ===================== /SCRIPTS ===================== -->

@stack('scripts')  
</body>
</html>
