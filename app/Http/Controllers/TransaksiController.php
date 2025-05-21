<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function tampilkanDataTransaksi(){
        $user = Auth::user();
        $pembelian = Pembelian::select('id_pembelian as id', 'total_harga', 'updated_at', DB::raw("'pembelian' as jenis"))->get();
        $penjualan = Pesanan::select('id_pesanan as id', 'total_harga', 'updated_at', DB::raw("'pesanan' as jenis"))->has('detailPesanan')->get();

        $transaksi = $pembelian->concat($penjualan)->sortByDesc('updated_at');

        // dd($transaksi->pluck('id'));
        return view('admin.transaksi', [
            'transaksi'=> $transaksi,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }
}
