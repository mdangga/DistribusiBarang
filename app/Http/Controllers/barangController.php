<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class barangController extends Controller
{
    public function tampilkanDataBarang(){
        $barang = Barang::all();
        $user = Auth::user();

        return view('admin.barang', compact('barang'), ['username' => $user->username,
            'email' => $user->email]);
    }

    public function updateDataBarang(Request $request, $id){
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->nama_barang = $request->nama_barang;
        $barang->kategori = $request->kategori;
        $barang->stok = $request->stok;
        $barang->satuan = $request->satuan;
        $barang->harga = $request->harga;

        return redirect()->route('admin.barang')->with('success', 'Data barang berhasil diperbarui.');
    }
}
