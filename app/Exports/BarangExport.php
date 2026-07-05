<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    protected $search;
    protected $stok;

    public function __construct($search = null, $stok = null)
    {
        $this->search = $search;
        $this->stok = $stok;
    }

    public function collection()
    {
        $query = Barang::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->stok == 'menipis') {
            $query->where('stok', '<=', 5);
        }

        return $query->get(['kode_barang', 'nama_barang', 'kategori', 'stok', 'satuan', 'kondisi', 'lokasi', 'keterangan']);
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Stok',
            'Satuan',
            'Kondisi',
            'Lokasi',
            'Keterangan',
        ];
    }
}
