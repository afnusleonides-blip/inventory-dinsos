<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dinsos</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Logo */
        .navbar-logo {
            height: 38px;
            margin-right: 8px;
            vertical-align: middle;
        }
        .brand-logo {
            height: 40px;
            margin-bottom: 6px;
        }
        @media (max-width: 768px) {
            .navbar-logo {
                height: 30px;
                margin-right: 5px;
            }
        }

        /* === Mobile Optimizations === */

        /* Content padding lebih kecil di HP */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 0.5rem !important;
            }
            .content-wrapper .container-fluid {
                padding: 0 !important;
            }
            .card-body {
                padding: 0.75rem !important;
            }
            .card-header {
                padding: 0.6rem 0.75rem !important;
            }
            .card-header .card-title {
                font-size: 0.95rem !important;
            }
            /* Tabel font lebih kecil */
            .table {
                font-size: 0.75rem !important;
            }
            .table th, .table td {
                padding: 0.4rem 0.35rem !important;
                white-space: nowrap;
            }
            /* Badge lebih kecil */
            .badge {
                font-size: 0.7rem !important;
            }
            /* Alert lebih compact */
            .alert {
                padding: 0.5rem 0.75rem !important;
                font-size: 0.8rem !important;
            }
            /* Heading lebih kecil */
            h3 { font-size: 1.1rem !important; }
            h4 { font-size: 1rem !important; }
            h5 { font-size: 0.9rem !important; }
            /* Card tools */
            .card-tools .btn-sm {
                padding: 0.2rem 0.4rem !important;
                font-size: 0.7rem !important;
            }
            /* Dashboard small boxes */
            .small-box .inner h3 {
                font-size: 1.4rem !important;
            }
            .small-box .inner p {
                font-size: 0.75rem !important;
            }
            .small-box .icon {
                font-size: 50px !important;
            }
            /* Form control */
            .form-control {
                font-size: 0.85rem !important;
            }
            /* Button */
            .btn {
                font-size: 0.8rem !important;
            }
            /* Grafik */
            canvas {
                max-height: 220px !important;
            }
            /* Pagination lebih kecil */
            .pagination {
                font-size: 0.75rem !important;
            }
            .page-link {
                padding: 0.3rem 0.5rem !important;
            }
        }

        /* Layar sangat kecil (HP lama) */
        @media (max-width: 400px) {
            .table {
                font-size: 0.7rem !important;
            }
            .small-box .inner h3 {
                font-size: 1.2rem !important;
            }
            .col-6 {
                padding-left: 5px !important;
                padding-right: 5px !important;
            }
        }

        /* Tabel wrapper dengan shadow scroll indicator */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            border-radius: 4px;
        }

        /* Sticky header navbar di mobile */
        .main-header {
            position: sticky;
            top: 0;
            z-index: 1030;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">

<div class="wrapper">

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        {{-- Mobile sidebar toggle --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <span class="navbar-brand ml-2 d-none d-sm-inline">
            <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo" class="navbar-logo">
            Inventory Dinsos
        </span>
        <span class="navbar-brand ml-2 d-sm-none" style="font-size:0.9rem;">
            <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo" class="navbar-logo">
            Inventory
        </span>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="/dashboard" class="brand-link text-center">
            <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo" class="brand-logo" onerror="this.style.display='none'">
            <br>
            <span class="brand-text font-weight-light">Inventory Dinsos</span>
        </a>

        <div class="sidebar">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-white"></i>
                </div>
                <div class="info">
                    <a href="/profile" class="d-block">{{ auth()->user()->name ?? 'Admin' }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu"
                    data-widget="treeview" data-accordion="false">

                    <li class="nav-header">MAIN NAVIGATION</li>

                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/barang" class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Data Barang</p>
                        </a>
                    </li>

                    <li class="nav-header">TRANSAKSI</li>

                    <li class="nav-item">
                        <a href="/barang-masuk" class="nav-link {{ request()->is('barang-masuk*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-arrow-circle-down"></i>
                            <p>Barang Masuk</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/barang-keluar" class="nav-link {{ request()->is('barang-keluar*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-arrow-circle-up"></i>
                            <p>Barang Keluar</p>
                        </a>
                    </li>

                    <li class="nav-header">LAPORAN</li>

                    <li class="nav-item">
                        <a href="/laporan/barang-masuk" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan</p>
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <li class="nav-header">ADMIN</li>

                    <li class="nav-item">
                        <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                    @endif

                    <li class="nav-header">AKUN</li>

                    <li class="nav-item">
                        <a href="/profile" class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Profil</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper p-3">
        @yield('content')
    </div>

</div>

<!-- jQuery + Bootstrap JS (dibutuhkan AdminLTE) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

{{-- Auto-collapse sidebar di mobile --}}
<script>
$(document).ready(function() {
    if ($(window).width() < 768) {
        $('body').addClass('sidebar-collapse').addClass('sidebar-open');
    }
});
</script>

<footer class="main-footer text-center">
    <strong>Sistem Inventory Barang Dinas Sosial Kabupaten Bengkayang</strong><br>
    Dikembangkan oleh <b>Leonides Afnus</b> | Institut Shanti Bhuana | 2026
</footer>

</body>
</html>
