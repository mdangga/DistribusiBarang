<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Tampilkan form pesanan dengan baris kosong yang tersedia
     */
    public function index()
    {
        // Cari pesanan kosong yang tersedia (pesanan tanpa detail)
        $emptyPesanan = Pesanan::whereDoesntHave('detailPesanan')
            ->where('total_harga', 0)
            ->first();
        
        // Jika tidak ada pesanan kosong, buat satu
        if (!$emptyPesanan) {
            $emptyPesanan = Pesanan::create([
                'total_harga' => 0,
                'id_pelanggan' => null
            ]);
        }
        
        // Ambil daftar barang untuk dropdown
        $barang = Barang::all();
        
        return view('form', compact('emptyPesanan', 'barang'));
    }

    /**
     * Simpan pesanan dan detail pesanan
     */
    public function store(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'id_pesanan' => 'required|exists:pesanan,id_pesanan',
            'id_pelanggan' => 'nullable|integer',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barang,id_barang',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            // Ambil pesanan yang akan diisi
            $pesanan = Pesanan::findOrFail($request->id_pesanan);
            
            // Update data pesanan
            $pesanan->update([
                'total_harga' => $request->total_harga,
                'id_pelanggan' => $request->id_pelanggan
            ]);
            
            // Simpan semua detail pesanan
            $items = $request->items;
            foreach ($items as $item) {
                // Skip jika tidak ada barang yang dipilih
                if (empty($item['id_barang'])) continue;
                
                // Ambil harga barang dari database
                $barang = Barang::findOrFail($item['id_barang']);
                
                // Buat detail pesanan
                DetailPesanan::create([
                    'jumlah' => $item['jumlah'],
                    'harga' => $barang->harga,
                    'id_barang' => $item['id_barang'],
                    'id_pesanan' => $request->id_pesanan
                ]);
            }
            
            // Buat pesanan kosong baru untuk transaksi berikutnya
            Pesanan::create([
                'total_harga' => 0,
                'id_pelanggan' => null
            ]);
            
            DB::commit();
            
            return redirect()->route('pesanan.list')
                ->with('success', 'Pesanan berhasil disimpan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Menampilkan daftar pesanan yang sudah ada
     */
    public function list()
    {
        // Ambil semua pesanan yang memiliki detail pesanan
        $pesanan = Pesanan::has('detailPesanan')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('list', compact('pesanan'));
    }
    
    /**
     * Menampilkan detail dari satu pesanan
     */
    public function show($id)
    {
        $pesanan = Pesanan::with('detailPesanan.barang')
            ->findOrFail($id);
        
        return view('detail', compact('pesanan'));
    }
}
