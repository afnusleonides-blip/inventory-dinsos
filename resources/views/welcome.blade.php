<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dinsos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div class="container">
            <span class="navbar-brand font-weight-bold">
                <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo" style="height:40px;margin-right:10px;vertical-align:middle;" onerror="this.style.display='none'">
                Inventory Dinsos
            </span>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container mt-5">

            <div class="row justify-content-center">
                <div class="col-md-8 text-center">

                    <div class="mb-4">
                        <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo Dinas Sosial" style="height:120px;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <i class="fas fa-warehouse fa-5x text-primary" style="display:none;"></i>
                    </div>

                    <h2 class="font-weight-bold mb-3">
                        Sistem Inventory<br>Dinas Sosial Kabupaten Bengkayang
                    </h2>

                    <p class="text-muted mb-4">
                        Kelola data barang, transaksi masuk & keluar, serta laporan dengan mudah
                    </p>

                    <div class="row justify-content-center mt-5">
                        <div class="col-md-4">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-box"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Data Barang</span>
                                    <span class="info-box-number">{{ \App\Models\Barang::count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Stok</span>
                                    <span class="info-box-number">{{ \App\Models\Barang::sum('stok') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        @auth
                            <a href="/dashboard" class="btn btn-primary btn-lg">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        @else
                            <a href="/login" class="btn btn-primary btn-lg mr-2">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>
                            <a href="/register" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-user-plus mr-2"></i> Register
                            </a>
                        @endauth
                    </div>

                </div>
            </div>

        </div>
    </div>

    <footer class="main-footer">
        <div class="container text-center">
            <strong>Inventory Dinsos</strong> &copy; {{ date('Y') }}
        </div>
    </footer>

</div>
</body>
</html>
