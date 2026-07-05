@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-md-6">
            <h3><b>Dashboard Inventory</b></h3>
            <p class="text-muted">Sistem Inventory Dinas Sosial Kabupaten Bengkayang</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow">
                <div class="inner">
                    <h3>{{ $totalBarang ?? 0 }}</h3>
                    <p>Total Barang</p>
                </div>
                <div class="icon" style="font-size: 70px;">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow">
                <div class="inner">
                    <h3>{{ $totalStok ?? 0 }}</h3>
                    <p>Total Stok</p>
                </div>
                <div class="icon" style="font-size: 70px;">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow">
                <div class="inner">
                    <h3>{{ $totalStokMenipis ?? 0 }}</h3>
                    <p>Stok Menipis</p>
                </div>
                <div class="icon" style="font-size: 70px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary shadow">
                <div class="inner">
                    <h3>{{ $totalBarangMasuk ?? 0 }}</h3>
                    <p>Total Masuk</p>
                </div>
                <div class="icon" style="font-size: 70px;">
                    <i class="fas fa-arrow-circle-down"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Restock -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i> Rekomendasi Restock
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Barang</th>
                                <th>Stok</th>
                                <th>Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($analytics['restockRecommendations'] ?? []) as $item)
                            <tr>
                                <td>{{ $item['nama'] }}</td>
                                <td>
                                    <span class="badge badge-warning">
                                        {{ $item['stok_saat_ini'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        +{{ $item['restock_qty'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    Semua barang dalam kondisi baik
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Menipis Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Stok Menipis (≤ 5)
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Barang</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($barangStokMenipis ?? []) as $item)
                            <tr>
                                <td>{{ $item->nama_barang }}</td>
                                <td>
                                    <span class="badge badge-danger">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td>{{ $item->satuan }}</td>
                                <td>
                                    @if($item->kondisi == 'Baik')
                                        <span class="badge badge-success">Baik</span>
                                    @elseif($item->kondisi == 'Rusak Ringan')
                                        <span class="badge badge-warning">Rusak Ringan</span>
                                    @else
                                        <span class="badge badge-danger">Rusak Berat</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Tidak ada stok menipis
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection