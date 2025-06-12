<?php

namespace App\Http\Controllers;

use App\Helpers\PieGraphDashboard;
use App\Models\Pembelian;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $now;

    public function __construct()
    {
        $this->now = Carbon::now();
    }

    public function showDashboard()
    {
        $user = Auth::user();

        // Get core metrics
        $currentMonth = $this->getCurrentMonthMetrics();
        $previousMonth = $this->getPreviousMonthMetrics();
        $profitAnalysis = $this->calculateProfitAnalysis($currentMonth, $previousMonth);

        // Get comprehensive performance data
        $ytdPerformance = $this->getYTDPerformance();
        $fullYearPerformance = $this->getFullYearPerformance();
        $businessStatus = $this->analyzeBusinessHealth($currentMonth, $previousMonth, $fullYearPerformance);

        // Get chart data
        $chartData = $this->getChartData();
        $recentData = $this->getRecentTransactions();

        return view('admin.dashboard', [
            'pesanan' => $this->formatMetric($currentMonth['orders'], $this->calculatePercentageChange($currentMonth['orders'], $previousMonth['orders'])),
            'pembelian' => $this->formatMetric($currentMonth['purchases'], $this->calculatePercentageChange($currentMonth['purchases'], $previousMonth['purchases'])),
            'pendapatan' => $this->formatMetric($currentMonth['revenue'], $this->calculatePercentageChange($currentMonth['revenue'], $previousMonth['revenue'])),
            'pengeluaran' => $this->formatMetric($currentMonth['expenses'], $this->calculatePercentageChange($currentMonth['expenses'], $previousMonth['expenses'])),
            'profit' => $profitAnalysis,
            'grafik_line' => $chartData['line'],
            'grafik_pie' => $chartData['pie'],
            'daftar_pesanan' => $recentData['orders'],
            'transaksi' => $recentData['transactions'],
            'username' => $user->username,
            'email' => $user->email,
            'ytd_performance' => $ytdPerformance,
            'full_year_performance' => $fullYearPerformance,
            'business_status' => $businessStatus,
        ]);
    }

    private function getCurrentMonthMetrics(): array
    {
        $start = $this->now->copy()->startOfMonth();
        $end = $this->now->copy()->endOfMonth();

        return $this->getMetricsForPeriod($start, $end);
    }

    private function getPreviousMonthMetrics(): array
    {
        $start = $this->now->copy()->subMonthNoOverflow()->startOfMonth();
        $end = $this->now->copy()->subMonthNoOverflow()->endOfMonth();

        return $this->getMetricsForPeriod($start, $end);
    }

    private function getMetricsForPeriod(Carbon $start, Carbon $end): array
    {
        $orders = Pesanan::whereBetween('tanggal', [$start, $end])
            ->has('detailPesanan')
            ->count();

        $revenue = Pesanan::whereBetween('tanggal', [$start, $end])
            ->has('detailPesanan')
            ->sum('total_harga');

        $purchases = Pembelian::whereBetween('tanggal', [$start, $end])->count();
        $expenses = Pembelian::whereBetween('tanggal', [$start, $end])->sum('total_harga');

        return [
            'orders' => $orders,
            'revenue' => $revenue,
            'purchases' => $purchases,
            'expenses' => $expenses,
            'net_profit' => $revenue - $expenses
        ];
    }

    private function calculateProfitAnalysis(array $current, array $previous): array
    {
        $currentProfit = $current['net_profit'];
        $previousProfit = $previous['net_profit'];

        // Get historical data for better analysis
        $threeMonthData = $this->getHistoricalProfits(3);
        $twelveMonthData = $this->getHistoricalProfits(12);

        // Calculate averages with minimum data validation
        $threeMonthAvg = $this->calculateSafeAverage($threeMonthData);
        $twelveMonthAvg = $this->calculateSafeAverage($twelveMonthData);

        return [
            'profit' => [
                $currentProfit - $previousProfit,
                $currentProfit - $threeMonthAvg,
                $currentProfit - $twelveMonthAvg
            ],
            'persentase' => [
                $this->calculateSafePercentageChange($currentProfit, $previousProfit),
                $this->calculateSafePercentageChange($currentProfit, $threeMonthAvg),
                $this->calculateSafePercentageChange($currentProfit, $twelveMonthAvg)
            ],
            'net_profit_bulan_ini' => $currentProfit,
            'net_profit_bulan_lalu' => $previousProfit,
            'rata_rata_profit_3_bulan' => $threeMonthAvg,
            'rata_rata_profit_12_bulan' => $twelveMonthAvg,
            'pendapatan_bulan_ini' => $current['revenue'],
            'pengeluaran_bulan_ini' => $current['expenses'],
            'pendapatan_bulan_lalu' => $previous['revenue'],
            'pengeluaran_bulan_lalu' => $previous['expenses'],
            'is_profitable_current' => $currentProfit > 0,
            'is_profitable_previous' => $previousProfit > 0,
            'profit_status' => $currentProfit > 0 ? 'profit' : 'loss',
            'detail_3_bulan' => $threeMonthData,
            'detail_12_bulan' => $twelveMonthData,
            'data_reliability' => $this->assessDataReliability(count($twelveMonthData))
        ];
    }

    private function getHistoricalProfits(int $months): array
    {
        $profits = [];

        for ($i = $months; $i >= 1; $i--) {
            $start = $this->now->copy()->subMonthNoOverflow($i)->startOfMonth();
            $end = $this->now->copy()->subMonthNoOverflow($i)->endOfMonth();

            $metrics = $this->getMetricsForPeriod($start, $end);
            $profits[] = $metrics['net_profit'];
        }

        return $profits;
    }

    private function calculateSafeAverage(array $data): float
    {
        if (empty($data)) {
            return 0;
        }

        // Filter out extreme outliers for new systems
        $validData = array_filter($data, function ($value) {
            return $value !== null && is_numeric($value);
        });

        if (empty($validData)) {
            return 0;
        }

        return array_sum($validData) / count($validData);
    }

    private function calculateSafePercentageChange($current, $previous): float
    {
        // Handle edge cases for new systems
        if ($previous == 0) {
            if ($current > 0) return 100;
            if ($current < 0) return -100;
            return 0;
        }

        $percentage = (($current - $previous) / abs($previous)) * 100;

        // Cap extreme percentages for new systems
        $percentage = $percentage;

        return round($percentage, 2);
    }

    private function calculatePercentageChange($current, $previous): float
    {
        return $this->calculateSafePercentageChange($current, $previous);
    }

    private function getYTDPerformance(): array
    {
        $start = $this->now->copy()->startOfYear();
        $end = $this->now->copy()->endOfMonth();

        $metrics = $this->getMetricsForPeriod($start, $end);

        return [
            'pendapatan_ytd' => $metrics['revenue'],
            'pengeluaran_ytd' => $metrics['expenses'],
            'net_profit_ytd' => $metrics['net_profit'],
            'is_profitable_ytd' => $metrics['net_profit'] > 0,
            'ytd_status' => $metrics['net_profit'] > 0 ? 'profit' : 'loss',
            'periode' => $start->format('M Y') . ' - ' . $end->format('M Y'),
        ];
    }

    private function getFullYearPerformance(): array
    {
        $start = $this->now->copy()->subMonthNoOverflow(11)->startOfMonth();
        $end = $this->now->copy()->endOfMonth();

        $metrics = $this->getMetricsForPeriod($start, $end);

        return [
            'pendapatan_full_year' => $metrics['revenue'],
            'pengeluaran_full_year' => $metrics['expenses'],
            'net_profit_full_year' => $metrics['net_profit'],
            'is_profitable_full_year' => $metrics['net_profit'] > 0,
            'full_year_status' => $metrics['net_profit'] > 0 ? 'profit' : 'loss',
            'periode' => $start->format('M Y') . ' - ' . $end->format('M Y'),
        ];
    }

    private function analyzeBusinessHealth(array $current, array $previous, array $fullYear): array
    {
        $currentProfitable = $current['net_profit'] > 0;
        $previousProfitable = $previous['net_profit'] > 0;
        $fullYearProfitable = $fullYear['is_profitable_full_year'];

        $consecutiveMonths = $this->calculateConsecutiveProfitableMonths();

        // Determine business status with consideration for new systems
        $status = $this->determineBusinessStatus($currentProfitable, $previousProfitable, $fullYearProfitable, $consecutiveMonths);

        return [
            'status' => $status['status'],
            'message' => $status['message'],
            'color' => $status['color'],
            'consecutive_profitable_months' => $consecutiveMonths,
            'recovery_indicator' => $currentProfitable && !$previousProfitable,
            'consistent_profit' => $consecutiveMonths >= 3,
            'needs_attention' => !$currentProfitable && $fullYear['net_profit_full_year'] < 0,
            'data_maturity' => $this->assessDataMaturity()
        ];
    }

    private function calculateConsecutiveProfitableMonths(): int
    {
        $consecutive = 0;

        for ($i = 0; $i < 12; $i++) {
            $start = $this->now->copy()->subMonthNoOverflow($i)->startOfMonth();
            $end = $this->now->copy()->subMonthNoOverflow($i)->endOfMonth();

            $metrics = $this->getMetricsForPeriod($start, $end);

            if ($metrics['net_profit'] > 0) {
                $consecutive++;
            } else {
                break;
            }
        }

        return $consecutive;
    }

    private function determineBusinessStatus(bool $currentProfitable, bool $previousProfitable, bool $fullYearProfitable, int $consecutiveMonths): array
    {
        if ($consecutiveMonths >= 6) {
            return [
                'status' => 'excellent',
                'message' => 'Business is performing excellently with consistent profits',
                'color' => 'success'
            ];
        }

        if ($currentProfitable && $previousProfitable && $consecutiveMonths >= 3) {
            return [
                'status' => 'profitable',
                'message' => 'Business is consistently profitable',
                'color' => 'success'
            ];
        }

        if ($currentProfitable && !$previousProfitable) {
            return [
                'status' => 'recovery',
                'message' => 'Business is recovering - showing positive signs',
                'color' => 'warning'
            ];
        }

        if ($currentProfitable) {
            return [
                'status' => 'improving',
                'message' => 'Business showing improvement',
                'color' => 'info'
            ];
        }

        if (!$currentProfitable && $previousProfitable) {
            return [
                'status' => 'declining',
                'message' => 'Business performance declining - needs attention',
                'color' => 'warning'
            ];
        }

        return [
            'status' => 'needs_attention',
            'message' => 'Business requires immediate attention',
            'color' => 'danger'
        ];
    }

    private function getChartData(): array
    {
        $start = $this->now->copy()->subMonthNoOverflow(11)->startOfMonth();

        $revenueData = $this->getMonthlyData('revenue', $start);
        $expenseData = $this->getMonthlyData('expenses', $start);

        $labels = [];
        $revenues = [];
        $expenses = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i);
            $key = $month->format('Y-m');

            $labels[] = $month->format('M Y');
            $revenues[] = $revenueData[$key] ?? 0;
            $expenses[] = $expenseData[$key] ?? 0;
        }

        return [
            'line' => [
                'labels' => $labels,
                'pendapatan' => $revenues,
                'pengeluaran' => $expenses,
            ],
            'pie' => $this->getPieChartData()
        ];
    }

    private function getMonthlyData(string $type, Carbon $startDate): array
    {
        $endDate = $this->now->copy()->endOfMonth();

        if ($type === 'revenue') {
            $data = Pesanan::selectRaw('
                YEAR(tanggal) as tahun,
                MONTH(tanggal) as bulan,
                SUM(total_harga) as total
            ')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->has('detailPesanan')
                ->groupBy(['tahun', 'bulan'])
                ->get();
        } else {
            $data = Pembelian::selectRaw('
                YEAR(tanggal) as tahun,
                MONTH(tanggal) as bulan,
                SUM(total_harga) as total
            ')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->groupBy(['tahun', 'bulan'])
                ->get();
        }

        $result = [];
        foreach ($data as $item) {
            $key = $item->tahun . '-' . str_pad($item->bulan, 2, '0', STR_PAD_LEFT);
            $result[$key] = $item->total;
        }

        return $result;
    }

    private function getPieChartData(): array
    {
        // 1 Week period
        $dailyStart = now()->startOfDay();
        $dailyEnd = now()->endOfDay();

        // 1 Week period
        $weekStart = $this->now->copy()->subWeek()->startOfWeek();
        $weekEnd = $this->now->copy()->endOfWeek();

        // 1 Month period
        $monthStart = $this->now->copy()->startOfMonth();
        $monthEnd = $this->now->copy()->endOfMonth();

        // 1 Year period
        $yearStart = $this->now->copy()->subMonthNoOverflow(12)->startOfMonth();
        $yearEnd = $this->now->copy();

        return [
            '1_day' => PieGraphDashboard::getKategoriData(
                $dailyStart,
                $dailyEnd
            ),
            '1_week' => PieGraphDashboard::getKategoriData(
                $weekStart,
                $weekEnd
            ),
            '1_month' => PieGraphDashboard::getKategoriData(
                $monthStart,
                $monthEnd
            ),
            '1_year' => PieGraphDashboard::getKategoriData(
                $yearStart,
                $yearEnd
            ),
        ];
    }

    private function getRecentTransactions(): array
    {
        $orders = Pesanan::with('Pelanggan')
            ->has('detailPesanan')
            ->orderBy('tanggal', 'desc')
            ->take(9)
            ->get();

        $purchases = Pembelian::select('kode_pembelian as kode', 'total_harga', 'tanggal', DB::raw("'pembelian' as jenis"))->get();
        $orderTransactions = Pesanan::select('kode_pesanan as kode', 'total_harga', 'tanggal', DB::raw("'pesanan' as jenis"))
            ->has('detailPesanan')
            ->get();

        $transactions = $purchases->concat($orderTransactions)
            ->sortByDesc('tanggal')
            ->take(5);

        return [
            'orders' => $orders,
            'transactions' => $transactions
        ];
    }

    private function formatMetric($value, $percentage): array
    {
        return [
            'total' => $value,
            'total_pesanan' => $value,
            'total_pembelian' => $value,
            'persentase' => $percentage,
        ];
    }

    private function assessDataReliability(int $monthsOfData): string
    {
        if ($monthsOfData < 3) return 'insufficient';
        if ($monthsOfData < 6) return 'limited';
        if ($monthsOfData < 12) return 'moderate';
        return 'reliable';
    }

    private function assessDataMaturity(): array
    {
        $firstTransaction = min(
            Pesanan::min('tanggal') ?? $this->now,
            Pembelian::min('tanggal') ?? $this->now
        );

        $monthsSinceStart = $this->now->diffInMonths($firstTransaction);

        return [
            'months_of_operation' => $monthsSinceStart,
            'maturity_level' => $this->assessDataReliability($monthsSinceStart),
            'recommendations' => $this->getRecommendationsForNewBusiness($monthsSinceStart)
        ];
    }

    private function getRecommendationsForNewBusiness(int $months): array
    {
        if ($months < 3) {
            return [
                'Focus on establishing consistent operations',
                'Track basic metrics carefully',
                'Avoid making major decisions based on early data'
            ];
        }

        if ($months < 6) {
            return [
                'Look for emerging patterns in your data',
                'Start analyzing monthly trends',
                'Consider seasonal factors'
            ];
        }

        if ($months < 12) {
            return [
                'Begin quarterly performance analysis',
                'Compare seasonal variations',
                'Plan for full year projections'
            ];
        }

        return [
            'Utilize full year-over-year comparisons',
            'Implement advanced analytics',
            'Focus on long-term strategic planning'
        ];
    }
}
