<?php

namespace App\Http\Controllers;

use App\Helpers\PieGraphDashboard;
use App\Models\Pembelian;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // Bulan lalu
        $startBulanSebelumnya = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $endBulanSebelumnya = $now->copy()->subMonthNoOverflow()->endOfMonth();

        // pesanan - KONSISTEN: gunakan has('detailPesanan') untuk semua
        $pesananBulanSebelumnya = Pesanan::whereBetween('tanggal', [$startBulanSebelumnya, $endBulanSebelumnya])
            ->has('detailPesanan')
            ->count();
        $pendapatanBulanSebelumnya = Pesanan::whereBetween('tanggal', [$startBulanSebelumnya, $endBulanSebelumnya])
            ->has('detailPesanan')
            ->sum('total_harga');

        // pembelian
        $pembelianBulanSebelumnya = Pembelian::whereBetween('tanggal', [$startBulanSebelumnya, $endBulanSebelumnya])
            ->count();;
        $pengeluaranBulanSebelumnya = Pembelian::whereBetween('tanggal', [$startBulanSebelumnya, $endBulanSebelumnya])
            ->sum('total_harga');

        // Bulan ini
        $startBulanSekarang = $now->copy()->startOfMonth();
        $endBulanSekarang = $now->copy()->endOfMonth();

        // Hitung pesanan
        $pesananBulanSekarang = Pesanan::whereBetween('tanggal', [$startBulanSekarang, $endBulanSekarang])
            ->has('detailPesanan')
            ->count();

        $pendapatanBulanSekarang = Pesanan::whereBetween('tanggal', [$startBulanSekarang, $endBulanSekarang])
            ->has('detailPesanan')
            ->sum('total_harga');

        // Hitung pembelian
        $pembelianBulanSekarang = Pembelian::whereBetween('tanggal', [$startBulanSekarang, $endBulanSekarang])
            ->count();

        $pengeluaranBulanSekarang = Pembelian::whereBetween('tanggal', [$startBulanSekarang, $endBulanSekarang])
            ->sum('total_harga');

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

        // PERBAIKAN: Profit calculation yang lebih jelas
        // net profit bulan ini dan bulan lalu
        $netProfitBulanIni = $pendapatanBulanSekarang - $pengeluaranBulanSekarang;
        $netProfitBulanLalu = $pendapatanBulanSebelumnya - $pengeluaranBulanSebelumnya;

        // Selisih profit bulan ini vs bulan lalu
        $netProfitMoM = $netProfitBulanIni - $netProfitBulanLalu;

        // PERBAIKAN: Persentase profit yang lebih akurat
        if ($netProfitBulanLalu == 0) {
            if ($netProfitBulanIni > 0) {
                $persentaseProfitMoM = 100;
            } elseif ($netProfitBulanIni < 0) {
                $persentaseProfitMoM = -100;
            } else {
                $persentaseProfitMoM = 0;
            }
        } else {
            $persentaseProfitMoM = (($netProfitBulanIni - $netProfitBulanLalu) / abs($netProfitBulanLalu)) * 100;
        }

        // PERBAIKAN UTAMA: net profit dengan 3 bulan sebelumnya - KONSISTEN dengan filter
        $ProfitTigaBulan = [];
        for ($i = 3; $i >= 1; $i--) {
            $start = $now->copy()->subMonthNoOverflow($i)->startOfMonth();
            $end = $now->copy()->subMonthNoOverflow($i)->endOfMonth();

            $pendapatan = Pesanan::whereBetween('tanggal', [$start, $end])
                ->has('detailPesanan')
                ->sum('total_harga');
            $pengeluaran = Pembelian::whereBetween('tanggal', [$start, $end])->sum('total_harga');

            $ProfitTigaBulan[] = $pendapatan - $pengeluaran;
        }

        $rataRataProfitTigaBulan = array_sum($ProfitTigaBulan) / 3;
        $netProfitThreeMonth = $netProfitBulanIni - $rataRataProfitTigaBulan;

        // PERBAIKAN: Logika persentase yang benar untuk profit
        if ($rataRataProfitTigaBulan == 0) {
            if ($netProfitBulanIni > 0) {
                $persentaseProfitTigaBulan = 100;
            } elseif ($netProfitBulanIni < 0) {
                $persentaseProfitTigaBulan = -100;
            } else {
                $persentaseProfitTigaBulan = 0;
            }
        } else {
            // PERBAIKAN KUNCI: Jika rata-rata negatif dan profit current positif
            if ($rataRataProfitTigaBulan < 0 && $netProfitBulanIni > 0) {
                // Dari loss ke profit = improvement yang sangat besar
                $persentaseProfitTigaBulan = ((abs($netProfitBulanIni) + abs($rataRataProfitTigaBulan)) / abs($rataRataProfitTigaBulan)) * 100;
            }
            // Jika rata-rata positif dan profit current negatif
            else if ($rataRataProfitTigaBulan > 0 && $netProfitBulanIni < 0) {
                // Dari profit ke loss = penurunan yang sangat besar (negatif)
                $persentaseProfitTigaBulan = - ((abs($netProfitBulanIni) + abs($rataRataProfitTigaBulan)) / abs($rataRataProfitTigaBulan)) * 100;
            }
            // Kasus normal (sama-sama positif atau sama-sama negatif)
            else {
                $persentaseProfitTigaBulan = (($netProfitBulanIni - $rataRataProfitTigaBulan) / abs($rataRataProfitTigaBulan)) * 100;
            }
        }

        // PERBAIKAN: Net Profit per bulan selama 12 bulan ke belakang (tidak termasuk bulan ini)
        $ProfitSatuTahun = [];
        $jumlahBulanProfit = 0;

        for ($i = 12; $i >= 1; $i--) {
            $start = $now->copy()->subMonthNoOverflow($i)->startOfMonth();
            $end = $now->copy()->subMonthNoOverflow($i)->endOfMonth();

            $pendapatan = Pesanan::whereBetween('tanggal', [$start, $end])
                ->has('detailPesanan')
                ->sum('total_harga');

            $pengeluaran = Pembelian::whereBetween('tanggal', [$start, $end])->sum('total_harga');

            $netProfit = $pendapatan - $pengeluaran;
            $ProfitSatuTahun[] = $netProfit;

            if ($netProfit > 0) {
                $jumlahBulanProfit++;
            }
        }

        // Hitung rata-rata dari net profit tahunan
        $rataRataProfitSatuTahun = count($ProfitSatuTahun) > 0
            ? array_sum($ProfitSatuTahun) / count($ProfitSatuTahun)
            : 0;

        // Gantilah nama variabel agar tidak membingungkan
        $selisihProfit = $netProfitBulanIni - $rataRataProfitSatuTahun;

        // Normalisasi divisor untuk menghindari lonjakan tak wajar
        $divisor = max(abs($rataRataProfitSatuTahun), 1);

        // Hitung persentase dengan kondisi khusus
        if ($rataRataProfitSatuTahun == 0) {
            // Tidak ada profit tahun lalu, maka:
            if ($netProfitBulanIni > 0) {
                $persentaseProfitSatuTahun = 100; // Bisa dianggap lonjakan besar
            } elseif ($netProfitBulanIni < 0) {
                $persentaseProfitSatuTahun = -100; // Kerugian dari basis 0
            } else {
                $persentaseProfitSatuTahun = 0;
            }
        } else {
            if ($rataRataProfitSatuTahun < 0 && $netProfitBulanIni > 0) {
                // Dari rugi ke untung (lonjakan positif)
                $persentaseProfitSatuTahun = (($netProfitBulanIni + abs($rataRataProfitSatuTahun)) / $divisor) * 100;
            } elseif ($rataRataProfitSatuTahun > 0 && $netProfitBulanIni < 0) {
                // Dari untung ke rugi (penurunan tajam)
                $persentaseProfitSatuTahun = - ((abs($netProfitBulanIni) + $rataRataProfitSatuTahun) / $divisor) * 100;
            } else {
                // Perubahan biasa
                $persentaseProfitSatuTahun = ($selisihProfit / $divisor) * 100;
            }
        }

        // Bulatkan hasil persentase ke 2 angka desimal
        $persentaseProfitSatuTahun = round($persentaseProfitSatuTahun, 2);

        // data array
        $pesanan = [
            'total_pesanan' => $pesananBulanSekarang,
            'persentase' => round($persentasePesanan, 2),
        ];

        $pembelian = [
            'total_pembelian' => $pembelianBulanSekarang,
            'persentase' => round($persentasePembelian, 2),
        ];

        $pendapatan = [
            'total' => $pendapatanBulanSekarang,
            'persentase' => round($persentasePendapatan, 2),
        ];

        $pengeluaran = [
            'total' => $pengeluaranBulanSekarang,
            'persentase' => round($persentasePengeluaran, 2),
        ];

        // === TAMBAHAN: YTD Performance Calculation ===
        $startYTD = $now->copy()->startOfYear();
        $endYTD = $now->copy()->endOfMonth();

        $pendapatanYTD = Pesanan::whereBetween('tanggal', [$startYTD, $endYTD])
            ->has('detailPesanan')
            ->sum('total_harga');
        $pengeluaranYTD = Pembelian::whereBetween('tanggal', [$startYTD, $endYTD])
            ->sum('total_harga');
        $netProfitYTD = $pendapatanYTD - $pengeluaranYTD;

        // === TAMBAHAN: 12 Month Performance (Full Year) ===
        $startFullYear = $now->copy()->subMonthNoOverflow(11)->startOfMonth();
        $endFullYear = $now->copy()->endOfMonth();

        $pendapatanFullYear = Pesanan::whereBetween('tanggal', [$startFullYear, $endFullYear])
            ->has('detailPesanan')
            ->sum('total_harga');
        $pengeluaranFullYear = Pembelian::whereBetween('tanggal', [$startFullYear, $endFullYear])
            ->sum('total_harga');
        $netProfitFullYear = $pendapatanFullYear - $pengeluaranFullYear;

        // === TAMBAHAN: Business Status Analysis ===
        $isCurrentMonthProfitable = $netProfitBulanIni > 0;
        $isPreviousMonthProfitable = $netProfitBulanLalu > 0;
        $isYTDProfitable = $netProfitYTD > 0;
        $isFullYearProfitable = $netProfitFullYear > 0;

        // Determine business status
        $businessStatus = 'stable'; // default
        $statusMessage = 'Business performance is stable';
        $statusColor = 'info'; // bootstrap color class

        if ($isCurrentMonthProfitable && !$isPreviousMonthProfitable) {
            $businessStatus = 'recovery';
            $statusMessage = 'Business is recovering - turning profitable';
            $statusColor = 'warning';
        } elseif ($isCurrentMonthProfitable && $isPreviousMonthProfitable) {
            if ($isFullYearProfitable) {
                $businessStatus = 'profitable';
                $statusMessage = 'Business is consistently profitable';
                $statusColor = 'success';
            } else {
                $businessStatus = 'improving';
                $statusMessage = 'Business showing consistent improvement';
                $statusColor = 'info';
            }
        } elseif (!$isCurrentMonthProfitable && $isPreviousMonthProfitable) {
            $businessStatus = 'declining';
            $statusMessage = 'Business performance declining';
            $statusColor = 'danger';
        } elseif (!$isCurrentMonthProfitable && !$isPreviousMonthProfitable) {
            $businessStatus = 'loss';
            $statusMessage = 'Business needs immediate attention';
            $statusColor = 'danger';
        }

        // Hitung consecutive profitable months
        $consecutiveProfitableMonths = 0;
        for ($i = 0; $i < 12; $i++) {
            $start = $now->copy()->subMonthNoOverflow($i)->startOfMonth();
            $end = $now->copy()->subMonthNoOverflow($i)->endOfMonth();

            $monthPendapatan = Pesanan::whereBetween('tanggal', [$start, $end])
                ->has('detailPesanan')
                ->sum('total_harga');
            $monthPengeluaran = Pembelian::whereBetween('tanggal', [$start, $end])
                ->sum('total_harga');

            if (($monthPendapatan - $monthPengeluaran) > 0) {
                $consecutiveProfitableMonths++;
            } else {
                break; // Stop counting if we hit a loss month
            }
        }

        // PERBAIKAN: Tambahkan informasi profit aktual untuk debugging
        $profit = [
            'profit' => [$netProfitMoM, $netProfitThreeMonth, $selisihProfit],
            'persentase' => [round($persentaseProfitMoM, 2), round($persentaseProfitTigaBulan, 2), round($persentaseProfitSatuTahun, 2)],
            // Tambahan untuk debugging dan konsistensi
            'net_profit_bulan_ini' => $netProfitBulanIni,
            'net_profit_bulan_lalu' => $netProfitBulanLalu,
            'rata_rata_profit_3_bulan' => $rataRataProfitTigaBulan,
            'rata_rata_profit_12_bulan' => $rataRataProfitSatuTahun,
            'pendapatan_bulan_ini' => $pendapatanBulanSekarang,
            'pengeluaran_bulan_ini' => $pengeluaranBulanSekarang,
            'pendapatan_bulan_lalu' => $pendapatanBulanSebelumnya,
            'pengeluaran_bulan_lalu' => $pengeluaranBulanSebelumnya,
            // Status profit untuk UI
            'is_profitable_current' => $netProfitBulanIni > 0,
            'is_profitable_previous' => $netProfitBulanLalu > 0,
            'profit_status' => $netProfitBulanIni > 0 ? 'profit' : 'loss',
            // Detail perhitungan untuk debugging
            'detail_3_bulan' => $ProfitTigaBulan,
            'detail_12_bulan' => $ProfitSatuTahun,
        ];

        // === TAMBAHAN: Data untuk Cards Baru ===
        $ytdPerformance = [
            'pendapatan_ytd' => $pendapatanYTD,
            'pengeluaran_ytd' => $pengeluaranYTD,
            'net_profit_ytd' => $netProfitYTD,
            'is_profitable_ytd' => $isYTDProfitable,
            'ytd_status' => $isYTDProfitable ? 'profit' : 'loss',
            'periode' => $startYTD->format('M Y') . ' - ' . $endYTD->format('M Y'),
        ];

        $fullYearPerformance = [
            'pendapatan_full_year' => $pendapatanFullYear,
            'pengeluaran_full_year' => $pengeluaranFullYear,
            'net_profit_full_year' => $netProfitFullYear,
            'is_profitable_full_year' => $isFullYearProfitable,
            'full_year_status' => $isFullYearProfitable ? 'profit' : 'loss',
            'periode' => $startFullYear->format('M Y') . ' - ' . $endFullYear->format('M Y'),
        ];

        $businessHealthStatus = [
            'status' => $businessStatus,
            'message' => $statusMessage,
            'color' => $statusColor,
            'consecutive_profitable_months' => $consecutiveProfitableMonths,
            'recovery_indicator' => $isCurrentMonthProfitable && !$isPreviousMonthProfitable,
            'consistent_profit' => $consecutiveProfitableMonths >= 3,
            'needs_attention' => !$isCurrentMonthProfitable && $netProfitFullYear < 0,
        ];

        // --- PERBAIKAN: Data Grafik dengan tahun yang konsisten ---
        $startDate = $now->copy()->subMonthNoOverflow(11)->startOfMonth(); // 12 bulan terakhir
        $endDate = $now->copy()->endOfMonth();

        // PERBAIKAN: Gunakan YEAR dan MONTH untuk konsistensi
        $pendapatanPerBulan = Pesanan::selectRaw('
            YEAR(tanggal) as tahun,
            MONTH(tanggal) as bulan,
            SUM(total_harga) as total_pendapatan
        ')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->has('detailPesanan')
            ->groupBy(['tahun', 'bulan'])
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $pengeluaranPerBulan = Pembelian::selectRaw('
            YEAR(tanggal) as tahun,
            MONTH(tanggal) as bulan,
            SUM(total_harga) as total_pengeluaran
        ')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy(['tahun', 'bulan'])
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Konversi ke array dengan key tahun-bulan
        $pendapatanData = [];
        $pengeluaranData = [];

        foreach ($pendapatanPerBulan as $data) {
            $key = $data->tahun . '-' . str_pad($data->bulan, 2, '0', STR_PAD_LEFT);
            $pendapatanData[$key] = $data->total_pendapatan;
        }

        foreach ($pengeluaranPerBulan as $data) {
            $key = $data->tahun . '-' . str_pad($data->bulan, 2, '0', STR_PAD_LEFT);
            $pengeluaranData[$key] = $data->total_pengeluaran;
        }

        $labels = [];
        $pendapatanGrafik = [];
        $pengeluaranGrafik = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $startDate->copy()->addMonths($i);
            $labels[] = $month->format('M Y');
            $key = $month->format('Y-m');

            $pendapatanGrafik[] = $pendapatanData[$key] ?? 0;
            $pengeluaranGrafik[] = $pengeluaranData[$key] ?? 0;
        }

        // --- Data Kategori Barang Paling Banyak Dibeli ---
        $startSatuTahun = $now->copy()->subMonthNoOverflow(12)->startOfMonth();
        $endSatuTahun = $now->copy()->endOfMonth();
        $grafikPieBulanSekarang = PieGraphDashboard::getKategoriData($startBulanSekarang, $endBulanSekarang);
        $grafikPieBulanSebelumnya = PieGraphDashboard::getKategoriData($startBulanSebelumnya, $endBulanSebelumnya);
        $grafikPieSatutahun = PieGraphDashboard::getKategoriData($startSatuTahun, $endSatuTahun);

        // Data untuk grafik
        $grafikLine = [
            'labels' => $labels,
            'pendapatan' => $pendapatanGrafik,
            'pengeluaran' => $pengeluaranGrafik,
        ];

        $grafikPie = [
            'bulan_sekarang' => $grafikPieBulanSekarang,
            'bulan_sebelumnya' => $grafikPieBulanSebelumnya,
            'Satu_tahun' => $grafikPieSatutahun,
        ];

        // Data untuk list pesanan
        $daftarPesanan = Pesanan::with('Pelanggan')
            ->has('detailPesanan')
            ->orderBy('tanggal', 'desc')
            ->take(9)
            ->get();

        // Data untuk list aktivitas
        $tabelPembelian = Pembelian::select('kode_pembelian as kode', 'total_harga', 'tanggal', DB::raw("'pembelian' as jenis"))->get();
        $tabelPesanan = Pesanan::select('kode_pesanan as kode', 'total_harga', 'tanggal', DB::raw("'pesanan' as jenis"))->has('detailPesanan')->get();

        $transaksi = $tabelPembelian->concat($tabelPesanan)->sortByDesc('tanggal')->take(5);

        return view('admin.dashboard', [
            'pesanan' => $pesanan,
            'pembelian' => $pembelian,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'profit' => $profit,
            'grafik_line' => $grafikLine,
            'grafik_pie' => $grafikPie,
            'daftar_pesanan' => $daftarPesanan,
            'transaksi' => $transaksi,
            'username' => $user->username,
            'email' => $user->email,
            // === TAMBAHAN: Data Cards Baru ===
            'ytd_performance' => $ytdPerformance,
            'full_year_performance' => $fullYearPerformance,
            'business_status' => $businessHealthStatus,
        ]);
    }
}
