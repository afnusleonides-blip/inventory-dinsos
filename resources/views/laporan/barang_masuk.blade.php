@extends('layouts.app')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success">
        <h3 class="card-title text-white">
            <i class="fas fa-file-alt"></i>
            Laporan Barang Masuk
        </h3>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <a href="/laporan/barang-masuk" class="btn btn-success btn-sm">
                <i class="fas fa-arrow-circle-down"></i> Laporan Barang Masuk
            </a>

            <a href="/laporan/barang-keluar" class="btn btn-danger btn-sm">
                <i class="fas fa-arrow-circle-up"></i> Laporan Barang Keluar
            </a>
        </div>

        <a href="/laporan/barang-masuk/pdf?{{ http_build_query(request()->only('tanggal_awal', 'tanggal_akhir')) }}"
        class="btn btn-primary btn-sm"
        target="_blank">

        <i class="fas fa-file-pdf"></i>
        Cetak PDF

        </a>

        <form method="GET" action="/laporan/barang-masuk" class="mb-3">

            <div class="row">

                <div class="col-md-4">
                    <label>Tanggal Awal</label>
                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-4">
                    <label>Tanggal Akhir</label>
                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-4 d-flex align-items-end">

                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Tampilkan
                    </button>

                    <a href="/laporan/barang-masuk"
                    class="btn btn-secondary">
                        Reset
                    </a>

                    </div>

                </div>

            </form>

        <div class="table-responsive">
        <table class="table table-bordered table-striped mb-0">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>

                @forelse($barangMasuks as $item)

                <tr>
                    <td>{{ $barangMasuks->firstItem() + $loop->index }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada data
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