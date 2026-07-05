<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function barangMasuk(Request $request)
    {
        $query = BarangMasuk::with('barang');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $barangMasuks = $query->latest()->paginate(10)
            ->appends($request->only('tanggal_awal', 'tanggal_akhir'));

        return view(
            'laporan.barang_masuk',
            compact('barangMasuks')
        );
    }

    public function barangKeluar(Request $request)
    {
        $query = BarangKeluar::with('barang');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $barangKeluars = $query->latest()->paginate(10)
            ->appends($request->only('tanggal_awal', 'tanggal_akhir'));

        return view(
            'laporan.barang_keluar',
            compact('barangKeluars')
        );
    }

    public function cetakBarangMasuk(Request $request)
    {
        $query = BarangMasuk::with('barang');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $barangMasuks = $query->latest()->get();

        $pdf = Pdf::loadView(
            'laporan.pdf_barang_masuk',
            compact('barangMasuks')
        );

        return $pdf->download('laporan_barang_masuk.pdf');
    }

    public function cetakBarangKeluar(Request $request)
    {
        $query = BarangKeluar::with('barang');

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $barangKeluars = $query->latest()->get();

        $pdf = Pdf::loadView(
            'laporan.pdf_barang_keluar',
            compact('barangKeluars')
        );

        return $pdf->download('laporan_barang_keluar.pdf');
    }
}
