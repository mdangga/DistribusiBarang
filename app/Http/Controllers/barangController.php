<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class barangController extends Controller
{
    public function tampilkanDataBarang(Request $request)
    {
        $user = Auth::user();
        // dd($request->all());
        
        $barang = Barang::when($request->barang_id != null, function ($q) use ($request) {
            return $q->where('id_barang', $request->barang_id);
        })
        ->when($request->nama != null, function ($q) use ($request) {
                return $q->where('nama_barang', 'LIKE', "%{$request->nama}%");
            })
            ->when($request->kategori != null, function ($q) use ($request) {
                return $q->where('kategori', $request->kategori);
            })
            ->paginate(10);
            $kategori = Barang::select('kategori')->distinct()->get();
        // dd($kategori);
        return view('admin.barang', [
            'barang' => $barang,
            'kategori' => $kategori,
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    public function addDataBarang(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_barang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('barang'),
            ],
            'kategori' => 'required|string',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
        ], [
            'nama_barang.unique' => 'Barang telah tersedia.',
        ]);

        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->kategori = $request->kategori;
        $barang->stok = $request->stok;
        $barang->satuan = $request->satuan;
        $barang->harga = $request->harga;
        $barang->save();

        return redirect()->route('admin.barang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function updateDataBarang(Request $request, $id_barang)
    {
        // Validasi
        $request->validate([
            'nama_barang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('barang')->ignore($id_barang, 'id_barang'),
            ],
            'kategori' => 'required|string',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
            'harga' => 'required|numeric',
        ], [
            'nama_barang.unique' => 'Barang telah tersedia.',
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

    public function autocomplete(Request $request)
    {
        $request->validate([
            'term' => 'required|string|min:2'
        ]);

        $term = $request->input('term');

        $results = Barang::query()
            ->where('nama_barang', 'LIKE', "%{$term}%")
            ->where('stok',  '!=', 0)
            ->orderBy('nama_barang')
            ->take(10)
            ->get([
                'id_barang as id',
                'nama_barang',
                'harga'
            ]);

        return response()->json($results);
    }
}
