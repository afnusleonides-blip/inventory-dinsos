<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Exports\BarangKeluarExport;
use Maatwebsite\Excel\Facades\Excel;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluars = BarangKeluar::with('barang')->latest()->paginate(10);

        return view('barang_keluar.index', compact('barangKeluars'));
    }

    public function create()
    {
        $barangs = Barang::all();

        return view('barang_keluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return redirect('/barang-keluar/create')
                ->with('error', 'Jumlah barang keluar melebihi stok yang tersedia');
        }

        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        $barang->stok = $barang->stok - $request->jumlah;
        $barang->save();

        return redirect('/barang-keluar')->with('success', 'Data barang keluar berhasil ditambahkan');
    }

    public function exportExcel()
    {
        return Excel::download(
            new BarangKeluarExport(),
            'barang_keluar_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }
}