<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PemasokController extends Controller
{
    public function tampilkanDataPemasok(Request $request)
    {
        $user = Auth::user();
        $sortBy = $request->get('sort_by', 'id_pemasok'); // default: urut berdasarkan ID
        $sortOrder = $request->get('sort_order', 'asc'); // default: naik

        $pemasok = Pemasok::withCount([
                'pembelian as total_pengiriman' => function ($query) use ($request) {
                    if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                        $query->whereBetween('updated_at', [
                            Carbon::parse($request->dateFrom)->startOfDay(),
                            Carbon::parse($request->dateTo)->endOfDay()
                        ]);
                    }
                }
            ])
            ->when(!empty($request->nama), function ($query) use ($request) {
                $query->where('nama_pemasok', 'like', '%' . $request->nama . '%');
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->appends($request->all());

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $results = $pemasok->slice(($page - 1) * $perPage, $perPage)->values();
        $pemasok = new LengthAwarePaginator($results, $pemasok->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        return view('admin.pemasok', [
            'pemasok' => $pemasok,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    public function addDataPemasok(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_pemasok' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pemasok'),
            ],
            'no_telpon' => 'required|string',
            'alamat' => 'required|string',
        ], [
            'nama_pemasok.required' => 'Nama pemasok tidak boleh kosong.',
            'nama_pemasok.unique' => 'Pemasok telah terdaftar.',
            'nama_pemasok.max' => 'Nama pemasok lebih dari 255 karakter',
            'kategori.required' => 'Kategori wajib diisi.',
            'no_telpon.required' => 'No Telephone wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);
        // dd($request->all());

        $pemasok = new Pemasok();
        $pemasok->nama_pemasok = $request->nama_pemasok;
        $pemasok->no_telpon = $request->no_telpon;
        $pemasok->alamat = $request->alamat;
        $pemasok->save();

        return redirect()->route('admin.pemasok')->with('success', 'Pemasok berhasil ditambahkan');
    }

    public function updateDataPemasok(Request $request, $id_pemasok)
    {
        // Validasi
        // dd($request->all());
        $request->validate([
            'nama_pemasok' => [
                'required',
                'string',
                'max:255',
            ],
            'no_telpon' => 'required|string',
            'alamat' => 'required|string',
        ], [
            'nama_pemasok.required' => 'Nama pemasok tidak boleh kosong.',
            'nama_pemasok.unique' => 'Pemasok telah terdaftar.',
            'nama_pemasok.max' => 'Nama pemasok lebih dari 255 karakter',
            'kategori.required' => 'Kategori wajib diisi.',
            'no_telpon.required' => 'No Telephone wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        // Update data
        $pemasok = Pemasok::findOrFail($id_pemasok);
        $pemasok->update([
            'nama_pemasok' => $request->nama_pemasok,
            'no_telpon' => $request->no_telpon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.pemasok')->with('success', 'Data berhasil diupdate!');
    }

    public function autocomplete(Request $request)
    {
        $request->validate([
            'term' => 'required|string|min:2'
        ]);

        $term = $request->input('term');

        $results = Pemasok::query()
            ->where('nama_pemasok', 'LIKE', "%{$term}%")
            ->orderBy('nama_pemasok')
            ->take(10)
            ->get([
                'id_pemasok as id',
                'nama_pemasok',
                'alamat',
                'no_telpon'
            ]);

        return response()->json($results);
    }
}