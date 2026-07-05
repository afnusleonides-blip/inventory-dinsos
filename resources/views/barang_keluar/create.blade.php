@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-danger">
        <h3 class="card-title text-white">
            <i class="fas fa-arrow-circle-up"></i>
            Tambah Barang Keluar
        </h3>
    </div>

    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/barang-keluar/store" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Barang</label>

                <select name="barang_id" class="form-control @error('barang_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Barang --</option>

                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                            (Stok : {{ $barang->stok }})
                        </option>
                    @endforeach

                </select>
                @error('barang_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Jumlah Keluar</label>

                <input
                    type="number"
                    name="jumlah"
                    class="form-control @error('jumlah') is-invalid @enderror"
                    value="{{ old('jumlah') }}"
                    required>
                @error('jumlah')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    class="form-control @error('tanggal') is-invalid @enderror"
                    value="{{ old('tanggal') }}"
                    required>
                @error('tanggal')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Keterangan</label>

                <textarea
                    name="keterangan"
                    class="form-control @error('keterangan') is-invalid @enderror"
                    rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-danger">
                <i class="fas fa-save"></i>
                Simpan
            </button>

            <a href="/barang-keluar" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection
