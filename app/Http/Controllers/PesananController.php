<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // dd($emptyPesanan);
        return view('form', compact('emptyPesanan', 'barang'));
    }

    /**
     * Simpan pesanan dan detail pesanan
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'kode_pesanan' => 'required|exists:pesanan,kode_pesanan',
            'id_pelanggan' => 'nullable|exists:pelanggan,id_pelanggan',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barang,id_barang',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $pesanan = Pesanan::findOrFail($request->kode_pesanan);

            // Validasi stok terlebih dahulu
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['id_barang']);
                if ($barang->stok < $item['jumlah']) {
                    throw new \Exception("Stok barang {$barang->nama_barang} tidak cukup.");
                }
            }

            $pesanan->update([
                'total_harga' => $request->total_harga,
                'id_pelanggan' => $request->id_pelanggan
            ]);

            foreach ($request->items as $item) {
                if (empty($item['id_barang'])) continue;

                $barang = Barang::findOrFail($item['id_barang']);

                // Simpan detail pesanan
                DetailPesanan::create([
                    'jumlah' => $item['jumlah'],
                    'harga' => $barang->harga,
                    'id_barang' => $item['id_barang'],
                    'kode_pesanan' => $request->kode_pesanan
                ]);

                // Kurangi stok barang
                $barang->stok -= $item['jumlah'];
                $barang->save();
            }

            DB::commit();

            return redirect()->route('pesanan.list')
                ->with('success', 'Pesanan berhasil disimpan dan stok barang diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Menampilkan daftar pesanan yang sudah ada tanpa login
     */
    public function list()
    {
        // Ambil semua pesanan yang memiliki detail pesanan
        $pesanan = Pesanan::with('Pelanggan')
            ->has('detailPesanan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('list', compact('pesanan'));
    }

    /**
     * Menampilkan daftar pesanan yang sudah ada melalui admin
     */
    public function listAdmin(Request $request)
    {
        $user = Auth::user();

        $query = Pesanan::with('pelanggan')->has('detailPesanan');

        if ($request->has(['dateFrom', 'dateTo'])) {
            $query->whereBetween('tanggal', [
                Carbon::parse($request->dateFrom)->startOfDay(),
                Carbon::parse($request->dateTo)->endOfDay()
            ]);
        }

        $pesanan = $query->paginate(10);
        // dd($pembelian);
        return view('admin.pesanan', [
            'pesanan' => $pesanan,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    /**
     * Menampilkan detail dari satu pesanan
     */
    public function show($id)
    {
        $pesanan = Pesanan::with('detailPesanan.barang', 'Pelanggan')
            ->findOrFail($id);

        return view('detail', compact('pesanan'));
    }
}
