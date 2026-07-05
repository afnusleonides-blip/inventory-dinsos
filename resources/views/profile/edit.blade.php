@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-3">
        <h4><i class="fas fa-user-cog mr-2"></i>Profil Saya</h4>
    </div>

    {{-- Status Messages --}}
    @if (session('status') === 'profile-updated')
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-1"></i> Profil berhasil diperbarui.
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    @if (session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-1"></i> Password berhasil diubah.
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">

            {{-- Info Profil --}}
            <div class="card shadow-sm">
                <div class="card-header bg-primary">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-id-card mr-2"></i>Informasi Profil
                    </h5>
                </div>
                <div class="card-body">

                    @if ($errors->any() && !$errors->hasBag('updatePassword') && !$errors->hasBag('userDeletion'))
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $user->role_display }}" disabled>
                                <small class="text-muted">Role hanya bisa diubah oleh admin</small>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Ubah Password --}}
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-warning">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-lock mr-2"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body">

                    @if ($errors->updatePassword->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->updatePassword->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password Saat Ini</label>
                            <div class="col-sm-9">
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password Baru</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key mr-1"></i> Ubah Password
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            {{-- Info Akun --}}
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-5x text-secondary mb-2"></i>
                    <h5 class="mt-2">{{ $user->name }}</h5>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    <span class="badge {{ $user->isAdmin() ? 'badge-danger' : 'badge-secondary' }} px-3 py-2">
                        <i class="fas {{ $user->isAdmin() ? 'fa-shield-alt' : 'fa-user' }} mr-1"></i>
                        {{ $user->role_display }}
                    </span>
                </div>
            </div>

            {{-- Hapus Akun --}}
            <div class="card shadow-sm mt-3 border-danger">
                <div class="card-header bg-danger">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-trash mr-2"></i>Hapus Akun
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        Setelah akun dihapus, semua data di akun ini akan hilang permanen.
                    </p>

                    @if ($errors->userDeletion->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->userDeletion->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteModal">
                        <i class="fas fa-trash mr-1"></i> Hapus Akun Saya
                    </button>
                </div>
            </div>

            {{-- Modal Konfirmasi Hapus --}}
            <div class="modal fade" id="deleteModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Hapus Akun
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <div class="modal-body">
                                <p>Anda yakin ingin menghapus akun? Semua data akan hilang permanen.</p>

                                <div class="form-group mb-0">
                                    <label>Masukkan password untuk konfirmasi</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash mr-1"></i> Hapus Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
