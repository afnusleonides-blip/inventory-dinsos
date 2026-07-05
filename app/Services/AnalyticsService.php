<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Carbon\Carbon;

class AnalyticsService
{
    public function getDashboardData($period = 'month')
    {
        $dateRange = $this->getDateRange($period);

        return [
            'stockTrendData' => $this->getStockTrend($dateRange),
            'topIncoming' => $this->getTopIncoming($dateRange),
            'topOutgoing' => $this->getTopOutgoing($dateRange),
            'conditionStats' => $this->getConditionStats(),
            'zeroStockItems' => $this->getZeroStockItems($dateRange),
            'restockRecommendations' => $this->getRestockRecommendations(),
        ];
    }

    private function getDateRange($period)
    {
        $end = Carbon::now();

        return match($period) {
            'week' => ['start' => $end->copy()->subWeek(), 'end' => $end],
            'year' => ['start' => $end->copy()->subYear(), 'end' => $end],
            'today' => ['start' => $end->copy()->startOfDay(), 'end' => $end],
            default => ['start' => $end->copy()->subMonth(), 'end' => $end],
        };
    }

    public function getStockTrend($dateRange = null)
    {
        $query = Barang::selectRaw('kategori, COUNT(*) as total, AVG(stok) as avg_stok')
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('total');

        return $query->get()->map(fn($item) => [
            'kategori' => $item->kategori,
            'total' => $item->total,
            'avg_stok' => round($item->avg_stok, 2),
        ])->toArray();
    }

    public function getTopIncoming($dateRange)
    {
        return BarangMasuk::with('barang')
            ->whereBetween('tanggal', [$dateRange['start'], $dateRange['end']])
            ->selectRaw('barang_id, SUM(jumlah) as total_masuk')
            ->groupBy('barang_id')
            ->orderByDesc('total_masuk')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'nama' => $item->barang->nama_barang,
                'kode' => $item->barang->kode_barang,
                'total' => $item->total_masuk,
            ])
            ->toArray();
    }

    public function getTopOutgoing($dateRange)
    {
        return BarangKeluar::with('barang')
            ->whereBetween('tanggal', [$dateRange['start'], $dateRange['end']])
            ->selectRaw('barang_id, SUM(jumlah) as total_keluar')
            ->groupBy('barang_id')
            ->orderByDesc('total_keluar')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'nama' => $item->barang->nama_barang,
                'kode' => $item->barang->kode_barang,
                'total' => $item->total_keluar,
            ])
            ->toArray();
    }

    public function getConditionStats()
    {
        $stats = Barang::selectRaw('kondisi, COUNT(*) as total')
            ->whereNotNull('kondisi')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi')
            ->toArray();

        return array_map(fn($value) => (int)$value, $stats);
    }

    public function getZeroStockItems($dateRange)
    {
        return Barang::where('stok', 0)
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get(['id', 'kode_barang', 'nama_barang'])
            ->toArray();
    }

    public function getRestockRecommendations()
    {
        $lowStockItems = Barang::where('stok', '<=', 5)
            ->where('stok', '>', 0)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'kode' => $item->kode_barang,
                'nama' => $item->nama_barang,
                'stok_saat_ini' => $item->stok,
                'restock_qty' => max(10, intval($item->stok * 2)),
            ])
            ->toArray();

        return $lowStockItems;
    }
}
