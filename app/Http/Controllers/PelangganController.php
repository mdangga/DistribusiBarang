<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    public function tampilkanDataPelanggan(Request $request)
    {
        $user = Auth::user();
        $sortBy = $request->get('sort_by', 'id_pelanggan'); // default: urut berdasarkan ID
        $sortOrder = $request->get('sort_order', 'asc'); // default: naik

        $pelanggan = Pelanggan::withCount([
            'pesanan as total_pesanan' => function ($query) use ($request) {
                if (!empty($request->dateFrom) && !empty($request->dateTo)) {
                    $query->whereBetween('updated_at', [
                        Carbon::parse($request->dateFrom)->startOfDay(),
                        Carbon::parse($request->dateTo)->endOfDay()
                    ]);
                }
            }
        ])->when(!empty($request->nama), function ($query) use ($request) {
            $query->where('nama_pelanggan', 'like', '%' . $request->nama . '%');
        })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10)
            ->appends($request->all());

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $results = $pelanggan->slice(($page - 1) * $perPage, $perPage)->values();
        $pelanggan = new LengthAwarePaginator($results, $pelanggan->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        return view('admin.pelanggan', [
            'pelanggan' => $pelanggan,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    public function addDataPelanggan(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_pelanggan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pelanggan'),
            ],
            'no_telpon' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'max:15',
            ],
            'alamat' => 'required|string',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan tidak boleh kosong.',
            'nama_pelanggan.unique' => 'Pelanggan telah terdaftar.',
            'nama_pelanggan.max' => 'Nama pelanggan lebih dari 255 karakter',
            'no_telpon.required' => 'No Telephone wajib diisi.',
            'no_telpon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telpon.max' => 'Nomor telepon terlalu panjang.',
            'alamat.required' => 'Satuan wajib diisi.',
        ]);
        // dd($request->all());

        $pelanggan = new Pelanggan();
        $pelanggan->nama_pelanggan = $request->nama_pelanggan;
        $pelanggan->no_telpon = $request->no_telpon;
        $pelanggan->alamat = $request->alamat;
        $pelanggan->save();

        return redirect()->route('admin.pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function updateDataPelanggan(Request $request, $id_pelanggan)
    {
        // Validasi
        // dd($request->all());
        $request->validate([
            'nama_pelanggan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pelanggan')->ignore($id_pelanggan, 'id_pelanggan'),
            ],
            'no_telpon' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'max:15',
            ],
            'alamat' => 'required|string',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan tidak boleh kosong.',
            'nama_pelanggan.unique' => 'Pelanggan telah terdaftar.',
            'nama_pelanggan.max' => 'Nama pelanggan lebih dari 255 karakter',
            'no_telpon.required' => 'No Telephone wajib diisi.',
            'no_telpon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telpon.max' => 'Nomor telepon terlalu panjang.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        // Update data
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_telpon' => $request->no_telpon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.pelanggan')->with('success', 'Data berhasil diupdate!');
    }

    public function autocomplete(Request $request)
    {
        $request->validate([
            'term' => 'required|string|min:2'
        ]);

        $term = $request->input('term');

        $results = Pelanggan::query()
            ->where('nama_pelanggan', 'LIKE', "%{$term}%")
            ->orderBy('nama_pelanggan')
            ->take(10)
            ->get([
                'id_pelanggan as id',
                'nama_pelanggan',
                'alamat',
                'no_telpon'
            ]);

        return response()->json($results);
    }
}
