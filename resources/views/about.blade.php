@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">
                <i class="fas fa-info-circle"></i> Tentang Sistem
            </h3>
        </div>

        <div class="card-body">

            <div class="text-center mb-4">
                <img src="{{ asset('images/logo-dinsos.png') }}"
                     alt="Logo Dinsos"
                     style="max-height:120px;">
            </div>

            <h4><b>Sistem Inventory Barang</b></h4>

            <p>
                Sistem Inventory Barang merupakan aplikasi berbasis web yang
                digunakan untuk membantu pengelolaan data inventaris barang
                pada Dinas Sosial Kabupaten Bengkayang.
            </p>

            <table class="table table-bordered">

                <tr>
                    <th width="250">Nama Sistem</th>
                    <td>Sistem Inventory Barang</td>
                </tr>

                <tr>
                    <th>Instansi</th>
                    <td>Dinas Sosial Kabupaten Bengkayang</td>
                </tr>

                <tr>
                    <th>Framework</th>
                    <td>Laravel 12</td>
                </tr>

                <tr>
                    <th>Database</th>
                    <td>MySQL</td>
                </tr>

                <tr>
                    <th>Pengembang</th>
                    <td>Leonides Afnus</td>
                </tr>

                <tr>
                    <th>Institusi</th>
                    <td>Institut Shanti Bhuana</td>
                </tr>

                <tr>
                    <th>Tahun Pengembangan</th>
                    <td>2026</td>
                </tr>

                <tr>
                    <th>Versi Sistem</th>
                    <td>1.0</td>
                </tr>

            </table>

        </div>
    </div>

</div>

@endsection