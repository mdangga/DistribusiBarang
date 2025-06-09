<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PembelianExport;
use Maatwebsite\Excel\Facades\Excel;


class PembelianController extends Controller
{
    public function addDataPembelian(Request $request)
    {
        try {
            dd($request->validate([
                'tanggal' => 'required|date_format:Y-m-d H:i:s',
                'id_pemasok' => 'required|integer|exists:pemasok,id_pemasok',
                'harga' => 'required|numeric|min:0',
            ], [
                'tanggal.required' => 'Tanggal wajib diisi',
                'tanggal.date_format' => 'Format tanggal tidak valid',
                'id_pemasok.required' => 'Pemasok wajib dipilih',
                'id_pemasok.integer' => 'ID Pemasok harus berupa angka',
                'id_pemasok.exists' => 'Pemasok yang dipilih tidak valid',
                'harga.required' => 'Harga wajib diisi',
                'harga.numeric' => 'Harga harus berupa angka',
                'harga.min' => 'Harga tidak boleh kurang dari 0',
            ]));
            Pembelian::create([
                'tanggal' => $request->tanggal,
                'id_pemasok' => $request->id_pemasok,
                'total_harga' => $request->harga,
            ]);
            return redirect()->route('admin.pembelian')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            // logger()->error('Store Error:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    public function listAdmin(Request $request)
    {
        $user = Auth::user();

        $query = Pembelian::with('Pemasok');

        if ($request->has(['dateFrom', 'dateTo'])) {
            $query->whereBetween('tanggal', [
                Carbon::parse($request->dateFrom)->startOfDay(),
                Carbon::parse($request->dateTo)->endOfDay()
            ]);
        }

        $pembelian = $query->orderBy('tanggal', 'desc')->paginate(10);
        // dd($pembelian);
        return view('admin.pembelian', [
            'pembelian' => $pembelian,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }



    public function cetak(Request $request)
    {
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $query = Pembelian::with('pemasok')
            ->when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('tanggal', [
                    \Carbon\Carbon::parse($dateFrom)->startOfDay(),
                    \Carbon\Carbon::parse($dateTo)->endOfDay()
                ]);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.pdfPembelian', [
            'pembelian' => $query,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);

        return $pdf->stream('laporan-pembelian.pdf');
    }


    public function export(Request $request)
    {
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $filename = 'data-pembelian';
        if ($dateFrom && $dateTo) {
            $filename .= '-' . Carbon::parse($dateFrom)->format('d-m-Y') . '-sampai-' . Carbon::parse($dateTo)->format('d-m-Y');
        }
        $filename .= '.xlsx';

        return Excel::download(new PembelianExport($dateFrom, $dateTo), $filename);
    }
}
