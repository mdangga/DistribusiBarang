<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pembelian;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Bulan lalu
        $startBulanSebelumnya = $now->copy()->subMonth()->startOfMonth();
        $endBulanSebelumnya = $now->copy()->subMonth()->endOfMonth();
        // pesanan
        $psnBulanSebelumnya = Pesanan::whereBetween('tanggal', [$startBulanSebelumnya, $endBulanSebelumnya]);
        $pesananBulanSebelumnya = $psnBulanSebelumnya->count();
        $pendapatanBulanSebelumnya = $psnBulanSebelumnya->sum('total_harga');
        // pembelian
        $pblBulanSebelumnya = Pembelian::whereBetween('tanggal', [$startBulanSebelumnya, $endBulanSebelumnya]);
        $pembelianBulanSebelumnya = $pblBulanSebelumnya->count();
        $pengeluaranBulanSebelumnya = $pblBulanSebelumnya->sum('total_harga');

        // Bulan ini
        $startBulanSekarang = $now->copy()->startOfMonth();
        $endBulanSekarang = $now->copy()->endOfMonth();
        // pesanan
        $psnBulanSekarang = Pesanan::whereBetween('tanggal', [$startBulanSekarang, $endBulanSekarang]);
        $pesananBulanSekarang = $psnBulanSekarang->count();
        $pendapatanBulanSekarang = $psnBulanSekarang->sum('total_harga');
        // pembelian
        $pblBulanSekarang = Pembelian::whereBetween('tanggal', [$startBulanSekarang, $endBulanSekarang]);
        $pembelianBulanSekarang = $pblBulanSekarang->count();
        $pengeluaranBulanSekarang = $pblBulanSekarang->sum('total_harga');

        // menghitung persentase peningkatan
        // pesanan
        if ($pesananBulanSebelumnya == 0) {
            $persentasePesanan = $pesananBulanSekarang > 0 ? 100 : 0;
        } else {
            $persentasePesanan = (($pesananBulanSekarang - $pesananBulanSebelumnya) / abs($pesananBulanSebelumnya)) * 100;
        }
        // pembelian
        if ($pembelianBulanSebelumnya == 0) {
            $persentasePembelian = $pembelianBulanSekarang > 0 ? 100 : 0;
        } else {
            $persentasePembelian = (($pembelianBulanSekarang - $pembelianBulanSebelumnya) / abs($pembelianBulanSebelumnya)) * 100;
        }
        // pendapatan
        if ($pendapatanBulanSebelumnya == 0) {
            $persentasePendapatan = $pendapatanBulanSekarang > 0 ? 100 : 0;
        } else {
            $persentasePendapatan = (($pendapatanBulanSekarang - $pendapatanBulanSebelumnya) / abs($pendapatanBulanSebelumnya)) * 100;
        }
        // pengeluaran
        if ($pengeluaranBulanSebelumnya == 0) {
            $persentasePengeluaran = $pengeluaranBulanSekarang > 0 ? 100 : 0;
        } else {
            $persentasePengeluaran = (($pengeluaranBulanSekarang - $pengeluaranBulanSebelumnya) / abs($pengeluaranBulanSebelumnya)) * 100;
        }
        // profit
        // net profit bulan ini
        $netProfitBulanIni = $pendapatanBulanSekarang - $pengeluaranBulanSekarang;
        $ProfitBulanLalu = $pendapatanBulanSebelumnya - $pengeluaranBulanSebelumnya;
        
        // net profit dengan bulan sebelumnya
        $netProfitMoM = $netProfitBulanIni - $ProfitBulanLalu;
        if ($ProfitBulanLalu == 0) {
            $persentaseProfitMoM = $netProfitBulanIni > 0 ? 100 : 0;
        } else {
            $persentaseProfitMoM = (($netProfitBulanIni - $ProfitBulanLalu) / abs($ProfitBulanLalu)) * 100;
        }

        // net profit dengan 3 bulan sebelumnya
        $ProfitTigaBulan = [];

        for ($i = 3; $i >= 1; $i--) {
            $start = $now->copy()->subMonths($i)->startOfMonth();
            $end = $now->copy()->subMonths($i)->endOfMonth();

            $pendapatan = Pesanan::whereBetween('tanggal', [$start, $end])->sum('total_harga');
            $pengeluaran = Pembelian::whereBetween('tanggal', [$start, $end])->sum('total_harga');

            $ProfitTigaBulan[] = $pendapatan - $pengeluaran;
        }

        $rataRataProfitTigaBulan = array_sum($ProfitTigaBulan) / 3;
        // net profit dengan 3 bulan
        $netProfitThreeMonth = $netProfitBulanIni - $rataRataProfitTigaBulan;

        if ($rataRataProfitTigaBulan == 0) {
            $persentaseProfitTigaBulan = $netProfitBulanIni > 0 ? 100 : 0;
        }else {
            $persentaseProfitTigaBulan = (($netProfitBulanIni - $rataRataProfitTigaBulan) / abs($rataRataProfitTigaBulan)) * 100;
        }

        // net profit dengan 1 tahun sebelumnya
        $ProfitSatuTahun = [];

        for ($i = 12; $i >= 1; $i--) {
            $start = $now->copy()->subMonths($i)->startOfMonth();
            $end = $now->copy()->subMonths($i)->endOfMonth();

            $pendapatan = Pesanan::whereBetween('tanggal', [$start, $end])->sum('total_harga');
            $pengeluaran = Pembelian::whereBetween('tanggal', [$start, $end])->sum('total_harga');

            $ProfitSatuTahun[] = $pendapatan - $pengeluaran;
        }

        $rataRataProfitSatuTahun = array_sum($ProfitSatuTahun) / 12;
        // net profit dengan 1 tahun
        $netProfitOneYear = $netProfitBulanIni - $rataRataProfitSatuTahun;

        if ($rataRataProfitSatuTahun == 0) {
            $persentaseProfitSatuTahun = $netProfitBulanIni > 0 ? 100 : 0;
        }else {
            $persentaseProfitSatuTahun = (($netProfitBulanIni - $rataRataProfitSatuTahun) / abs($rataRataProfitSatuTahun)) * 100;
        }

        // data array
        // pesanan
        $pesanan = [
            'total_pesanan' => $pesananBulanSekarang,
            'persentase' => round($persentasePesanan, 2),
        ];
        // pembelian
        $pembelian = [
            'total_pembelian' => $pembelianBulanSekarang,
            'persentase' => round($persentasePembelian, 2),
        ];
        // pendapatan
        $pendapatan = [
            'total' => $pendapatanBulanSekarang,
            'persentase' => round($persentasePendapatan, 2),
        ];
        // pengeluaran
        $pengeluaran = [
            'total' => $pengeluaranBulanSekarang,
            'persentase' => round($persentasePengeluaran, 2),
        ];
        // profit
        $profit = [
            'profit' => [$netProfitMoM, $netProfitThreeMonth, $netProfitOneYear],
            'persentase' => [round($persentaseProfitMoM, 2), round($persentaseProfitTigaBulan, 2), round($persentaseProfitSatuTahun, 2)],
        ];

        // --- Data Grafik Pendapatan & Pengeluaran (12 Bulan Terakhir) ---
        $startDate = $now->copy()->subMonths(11)->startOfMonth(); // 12 bulan terakhir
        $endDate = $now->copy()->endOfMonth();

        // Data Pendapatan per Bulan
        // Data Pesanan per Bulan
        $pesananPerBulan = Pesanan::selectRaw('
        MONTH(tanggal) as bulan,
        COUNT(*) as total_pesanan
        ')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total_pesanan', 'bulan')
            ->toArray();

        // Data Pembelian per Bulan
        $pembelianPerBulan = Pembelian::selectRaw('
        MONTH(tanggal) as bulan,
        COUNT(*) as total_pembelian
        ')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('total_pembelian', 'bulan')
            ->toArray();

        $labels = [];
        $pesananData = [];
        $pembelianData = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $startDate->copy()->addMonths($i);
            $labels[] = $month->format('M Y');
            $bulan = $month->month;

            $pesananData[] = $pesananPerBulan[$bulan] ?? 0;
            $pembelianData[] = $pembelianPerBulan[$bulan] ?? 0;
        }

        // --- Data Kategori Barang Paling Banyak Dibeli ---
        $allKategori = DetailPesanan::selectRaw('
            barang.kategori,
            SUM(detail_pesanan.jumlah) as total_terjual
        ')
            ->join('barang', 'detail_pesanan.id_barang', '=', 'barang.id_barang')
            ->whereBetween('detail_pesanan.created_at', [$startBulanSekarang, $endBulanSekarang])
            ->groupBy('barang.kategori')
            ->orderByDesc('total_terjual')
            ->get();

        // Pisahkan 3 teratas dan gabungkan sisanya sebagai "Other"
        $topKategori = $allKategori->take(3);
        $otherKategori = $allKategori->slice(3);

        // Hitung total untuk "Other"
        $totalOther = $otherKategori->sum('total_terjual');

        // Format data untuk chart
        $labelsKategori = $topKategori->pluck('kategori')->toArray();
        $dataKategori = $topKategori->pluck('total_terjual')->toArray();

        // Tambahkan "Other" jika ada
        if ($totalOther > 0) {
            $labelsKategori[] = 'Other';
            $dataKategori[] = $totalOther;
        }

        // Data untuk grafik
        $grafikLine = [
            'labels' => $labels,
            'pesanan' => $pesananData,
            'pembelian' => $pembelianData,
        ];
        $grafikPie = [
            'labels' => $labelsKategori,
            'data' => $dataKategori,
        ];

        // Data untuk list pesanan
        $daftarPesanan = Pesanan::with('Pelanggan')
            ->has('detailPesanan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'pesanan' => $pesanan,
            'pembelian' => $pembelian,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'daftar_pesanan' => $daftarPesanan,
            'profit' => $profit,
            'grafik_line' => $grafikLine,
            'grafik_pie' => $grafikPie,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }
}
