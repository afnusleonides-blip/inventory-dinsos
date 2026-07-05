<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangMasukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BarangMasuk::with('barang')
            ->get()
            ->map(function ($item) {
                return [
                    $item->tanggal,
                    $item->barang->kode_barang,
                    $item->barang->nama_barang,
                    $item->jumlah,
                    $item->keterangan,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode Barang',
            'Nama Barang',
            'Jumlah Masuk',
            'Keterangan',
        ];
    }
}
