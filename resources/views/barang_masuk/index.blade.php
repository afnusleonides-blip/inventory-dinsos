@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="card shadow">
    <div class="card-header bg-primary">
        <h3 class="card-title text-white">
            <i class="fas fa-arrow-circle-down"></i> Data Barang Masuk
        </h3>

        <div class="card-tools">
            <a href="/barang-masuk/create" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Tambah Barang Masuk
            </a>
            <a href="/barang-masuk/export" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($barangMasuks as $barangMasuk)
                <tr>
                    <td>{{ $barangMasuks->firstItem() + $loop->index }}</td>
                    <td>{{ $barangMasuk->tanggal }}</td>
                    <td>{{ $barangMasuk->barang->nama_barang }}</td>
                    <td>
                        <span class="badge badge-success">
                            +{{ $barangMasuk->jumlah }}
                        </span>
                    </td>
                    <td>{{ $barangMasuk->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada data barang masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $barangMasuks->links() }}
        </div>
    </div>
</div>

@endsection