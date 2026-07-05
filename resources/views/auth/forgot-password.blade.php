<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Inventory Dinsos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="hold-transition login-page">

<div class="login-box">

    <div class="card card-outline card-warning shadow">
        <div class="card-header text-center">
            <div class="mb-2">
                <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo" style="height:70px;" onerror="this.style.display='none'">
            </div>
            <h5 class="mb-0">
                <i class="fas fa-unlock-alt mr-1"></i>
                <b>Lupa</b> Password
            </h5>
            <p class="text-muted mb-0 mt-1">Masukkan email Anda untuk menerima link reset</p>
        </div>

        <div class="card-body">

            {{-- Session Status --}}
            @if(session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="text-muted mb-3">
                Lupa password? Masukkan email yang terdaftar, kami akan kirim link reset ke email Anda.
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group mb-3">
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email"
                        value="{{ old('email') }}"
                        required
                        autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-paper-plane mr-1"></i> Kirim Link Reset
                        </button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-0 text-center">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                </a>
            </p>

        </div>
    </div>

    <div class="text-center mt-3">
        <small class="text-muted">
            Dinas Sosial Kabupaten Bengkayang &copy; {{ date('Y') }}
        </small>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
