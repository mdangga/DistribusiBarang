<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function tampilkanDataPelanggan(Request $request)
    {
        $user = Auth::user();

        $pelanggan = Pelanggan::withCount([
            'pesanan as total_pesanan' => function ($query) use ($request) {
                if ($request->date != null) {
                    $query->whereDate('updated_at', $request->date);
                }
            }
        ])->get();

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
