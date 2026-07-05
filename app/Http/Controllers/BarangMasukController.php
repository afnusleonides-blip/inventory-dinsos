<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Exports\BarangMasukExport;
use Maatwebsite\Excel\Facades\Excel;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')->latest()->paginate(10);

        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();

        return view('barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $barangMasuk = BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        $barang = Barang::find($request->barang_id);
        $barang->stok = $barang->stok + $request->jumlah;
        $barang->save();

        return redirect('/barang-masuk')->with('success', 'Data barang masuk berhasil ditambahkan');
    }

    public function exportExcel()
    {
        return Excel::download(
            new BarangMasukExport(),
            'barang_masuk_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }
}