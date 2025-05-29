<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function tampilkanDataTransaksi(Request $request)
    {
        $user = Auth::user();
        $pembelian = Pembelian::select('kode_pembelian as kode', 'total_harga', 'updated_at', DB::raw("'pembelian' as jenis"))->get();
        $penjualan = Pesanan::select('kode_pesanan as kode', 'total_harga', 'updated_at', DB::raw("'pesanan' as jenis"))->has('detailPesanan')->get();

        $transaksi = $pembelian->concat($penjualan)->sortByDesc('updated_at');

        // Apply date filter if requested
        if ($request->date != null) {
            $transaksi = $transaksi->filter(function ($item) use ($request) {
                return $item->updated_at->format('Y-m-d') == $request->date;
            });
        }

        // Paginate the results manually
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $results = $transaksi->slice(($page - 1) * $perPage, $perPage)->values();
        $transaksis = new LengthAwarePaginator($results, $transaksi->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        // dd($transaksi->pluck('id'));
        return view('admin.transaksi', [
            'transaksi' => $transaksis,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }
}
