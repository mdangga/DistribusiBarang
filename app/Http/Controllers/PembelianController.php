<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PembelianController extends Controller
{
    public function addDataPembelian(Request $request)
    {
        try {
            $request->validate([
                'tanggal' => 'required|date_format:Y-m-d',
                'id_pemasok' => 'required|integer|exists:pemasok,id_pemasok',
                'harga' => 'required|numeric|min:0',
            ]);

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

        $pembelian = $query->paginate(10);
        // dd($pembelian);
        return view('admin.pembelian', [
            'pembelian' => $pembelian,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }
}
