<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PesananExport;
use Maatwebsite\Excel\Facades\Excel;

class PesananController extends Controller
{
    /**
     * Tampilkan form pesanan dengan baris kosong yang tersedia
     */
    public function index()
    {
        // Ambil daftar barang untuk dropdown
        $barang = Barang::all();
        return view('form', compact('barang'));
    }

    /**
     * Simpan pesanan dan detail pesanan
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'nullable|exists:pelanggan,id_pelanggan',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|exists:barang,id_barang',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Validasi stok terlebih dahulu
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['id_barang']);
                if ($barang->stok < $item['jumlah']) {
                    throw new \Exception("Stok barang {$barang->nama_barang} tidak cukup.");
                }
            }

            $pesanan = Pesanan::create([
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
                    'kode_pesanan' => $pesanan->kode_pesanan
                ]);

                // Kurangi stok barang
                $barang->stok -= $item['jumlah'];
                $barang->save();
            }

            DB::commit();

            return redirect()->route('pesanan.show', $pesanan->kode_pesanan)
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
            ->orderBy('tanggal', 'desc')
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

        $pesanan = $query->orderBy('tanggal', 'desc')->paginate(10);
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

    /**
     * Menampilkan detail dari satu pesanan dari admin
     */
    public function showAdmin($id)
    {
        $user = Auth::user();
        $pesanan = Pesanan::with('detailPesanan.barang', 'Pelanggan')
            ->findOrFail($id);

        return view('admin.detailPesanan', [
            'pesanan' => $pesanan,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }


    
    public function cetak(Request $request)
    {
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $query = Pesanan::with('pelanggan')
            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('tanggal', [
                    \Carbon\Carbon::parse($dateFrom)->startOfDay(),
                    \Carbon\Carbon::parse($dateTo)->endOfDay()
                ]);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.pdfPesanan', [
            'pesanan' => $query,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);

        return $pdf->stream('laporan-pesanan.pdf');
    }


    public function export(Request $request)
    {
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $filename = 'data-pesanan';
        if ($dateFrom && $dateTo) {
            $filename .= '-' . Carbon::parse($dateFrom)->format('d-m-Y') . '-sampai-' . Carbon::parse($dateTo)->format('d-m-Y');
        }
        $filename .= '.xlsx';

        return Excel::download(new PesananExport($dateFrom, $dateTo), $filename);
    }
}