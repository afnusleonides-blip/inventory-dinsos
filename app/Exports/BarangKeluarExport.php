<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangKeluarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BarangKeluar::with('barang')
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
            'Jumlah Keluar',
            'Keterangan',
        ];
    }
}
