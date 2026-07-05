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
            <i class="fas fa-box"></i> Data Barang
        </h3>

        <div class="card-tools">
            <a href="/barang/create" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Tambah Barang
            </a>
            <a href="/barang/export?{{ http_build_query(request()->only('search', 'stok')) }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <div class="card-body">

        <form method="GET" action="/barang" class="mb-3">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari nama atau kode barang..."
                               value="{{ request('search') }}">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3 mb-2">
                    <select name="stok" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Stok</option>
                        <option value="menipis" {{ request('stok') == 'menipis' ? 'selected' : '' }}>
                            ⚠ Stok Menipis
                        </option>
                    </select>
                </div>

                <div class="col-6 col-md-3 mb-2">
                    <a href="/barang" class="btn btn-secondary btn-block">
                        <i class="fas fa-redo"></i>
                        <span class="d-none d-md-inline">Reset</span>
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td>{{ $barangs->firstItem() + $loop->index }}</td>
                        <td>
                            @if($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto" style="max-width: 50px; height: 50px; object-fit: cover;" class="rounded">
                            @else
                                <img src="https://via.placeholder.com/50?text=No+Image" alt="No Image" style="max-width: 50px; height: 50px;">
                            @endif
                        </td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori ?? '-' }}</td>

                        <td>
                            @if($barang->stok <= 5)
                                <span class="badge badge-danger">{{ $barang->stok }}</span>
                            @elseif($barang->stok <= 10)
                                <span class="badge badge-warning">{{ $barang->stok }}</span>
                            @else
                                <span class="badge badge-success">{{ $barang->stok }}</span>
                            @endif
                        </td>

                        <td>{{ $barang->satuan }}</td>

                        <td>
                            @if($barang->kondisi == 'Baik')
                                <span class="badge badge-success">Baik</span>
                            @elseif($barang->kondisi == 'Rusak Ringan')
                                <span class="badge badge-warning">Rusak Ringan</span>
                            @elseif($barang->kondisi == 'Rusak Berat')
                                <span class="badge badge-danger">Rusak Berat</span>
                            @else
                                <span class="badge badge-secondary">-</span>
                            @endif
                        </td>

                        <td>{{ $barang->lokasi ?? '-' }}</td>

                        <td>
                            <a href="/barang/edit/{{ $barang->id }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form action="/barang/delete/{{ $barang->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Belum ada data barang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $barangs->links() }}
        </div>
    </div>
</div>

@endsection