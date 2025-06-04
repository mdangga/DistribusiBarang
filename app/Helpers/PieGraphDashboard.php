<?php
namespace App\Helpers;

use App\Models\DetailPesanan;

class PieGraphDashboard
{
    public static function getKategoriData($startDate, $endDate)
    {
        $allKategori = DetailPesanan::selectRaw('
        barang.kategori,
        SUM(detail_pesanan.jumlah) as total_terjual
    ')
            ->join('barang', 'detail_pesanan.id_barang', '=', 'barang.id_barang')
            ->whereBetween('detail_pesanan.created_at', [$startDate, $endDate])
            ->groupBy('barang.kategori')
            ->orderByDesc('total_terjual')
            ->get();

        $topKategori = $allKategori->take(5);
        $otherKategori = $allKategori->slice(5);
        $totalOther = $otherKategori->sum('total_terjual');

        $labels = $topKategori->pluck('kategori')->toArray();
        $data = $topKategori->pluck('total_terjual')->toArray();

        if ($totalOther > 0) {
            $labels[] = 'Other';
            $data[] = $totalOther;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
