<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Exports\BarangExport;
use App\Exports\BarangMasukExport;
use App\Exports\BarangKeluarExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Services\AnalyticsService;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        // Search by nama or kode
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        // Filter stok menipis
        if ($request->stok == 'menipis') {
            $query->where('stok', '<=', 5);
        }

        $barangs = $query->latest()->paginate(10)
            ->appends($request->only('search', 'stok'));

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:100|unique:barangs,kode_barang',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'kategori' => 'nullable|string|max:100',
            'kondisi' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('barangs', $file, $filename);
            $data['foto'] = $path;
        }

        Barang::create($data);
        return redirect('/barang')->with('success', 'Data berhasil ditambahkan');
    }
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:100|unique:barangs,kode_barang,' . $id,
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'kategori' => 'nullable|string|max:100',
            'kondisi' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $barang = Barang::findOrFail($id);
        $data = [
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'kategori' => $request->kategori,
            'kondisi' => $request->kondisi,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('barangs', $file, $filename);
            $data['foto'] = $path;
        } elseif ($request->input('delete_foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = null;
        }

        $barang->update($data);
        return redirect('/barang')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect('/barang')->with('success', 'Data berhasil dihapus');
    }

    public function exportBarang(Request $request)
    {
        return Excel::download(
            new BarangExport($request->search, $request->stok),
            'barang_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }

    public function dashboard()
    {
        $period = request('period', 'month');
        $analyticsService = new AnalyticsService();
        $analytics = $analyticsService->getDashboardData($period);

        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $totalBarangMasuk = BarangMasuk::sum('jumlah');
        $totalBarangKeluar = BarangKeluar::sum('jumlah');
        $totalStokMenipis = Barang::where('stok', '<=', 5)->count();

        // Kategori stats untuk pie chart
        $kategoriData = Barang::selectRaw('kategori, count(*) as total')
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $kategoriLabels = $kategoriData->pluck('kategori')->toArray();
        $kategoriCounts = $kategoriData->pluck('total')->toArray();

        $tanpaKategori = Barang::whereNull('kategori')->count();
        if ($tanpaKategori > 0) {
            $kategoriLabels[] = 'Tanpa Kategori';
            $kategoriCounts[] = $tanpaKategori;
        }

        $barangStokMenipis = Barang::where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalStok',
            'totalBarangMasuk',
            'totalBarangKeluar',
            'totalStokMenipis',
            'kategoriLabels',
            'kategoriCounts',
            'barangStokMenipis',
            'analytics',
            'period'
        ));
    }
}

