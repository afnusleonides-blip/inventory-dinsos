@extends('layouts.app')

@section('content')

<div class="card shadow">
    <div class="card-header bg-danger">

        <h3 class="card-title text-white">
            <i class="fas fa-arrow-circle-up"></i>
            Data Barang Keluar
        </h3>

        <div class="card-tools">
            <a href="/barang-keluar/create"
               class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i>
                Tambah Barang Keluar
            </a>
            <a href="/barang-keluar/export" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">
        <table class="table table-bordered table-striped mb-0">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Keluar</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>

                @forelse($barangKeluars as $barangKeluar)

                <tr>
                    <td>{{ $barangKeluars->firstItem() + $loop->index }}</td>
                    <td>{{ $barangKeluar->tanggal }}</td>
                    <td>{{ $barangKeluar->barang->nama_barang }}</td>

                    <td>
                        <span class="badge badge-danger">
                            -{{ $barangKeluar->jumlah }}
                        </span>
                    </td>

                    <td>
                        {{ $barangKeluar->keterangan ?? '-' }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada data barang keluar
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $barangKeluars->links() }}
        </div>

    </div>

</div>

@endsection