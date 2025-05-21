<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function tampilkanDataPelanggan()
    {
        $barang = Pelanggan::all();
        $user = Auth::user();

        return view('admin.barang', compact('barang'), [
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
