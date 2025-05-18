<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class barangController extends Controller
{
    public function tampilkanDataBarang()
    {
        $barang = Barang::all();
        $user = Auth::user();

        return view('admin.barang', compact('barang'), [
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    public function updateDataBarang(Request $request, $id_barang)
    {
        // Validasi
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        // Update data
        $barang = Barang::findOrFail($id_barang);
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.barang')->with('success', 'Data berhasil diupdate!');
    }
}
