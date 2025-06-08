<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;

class barangController extends Controller
{
    public function tampilkanDataBarang(Request $request)
    {
        $user = Auth::user();

        $query = Barang::query()
            ->when($request->barang_id, function ($q) use ($request) {
                return $q->where('id_barang', $request->barang_id);
            })
            ->when($request->nama, function ($q) use ($request) {
                return $q->where('nama_barang', 'LIKE', "%{$request->nama}%");
            })
            ->when($request->kategori, function ($q) use ($request) {
                return $q->where('kategori', $request->kategori);
            })
            ->when($request->filter_stok === 'minimum', function ($q) {
                return $q->where('stok', '<', 20);
            });

        // Terapkan sort hanya jika ada parameter sort_by dan sort_order
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->sort_by, $request->sort_order);
        }

        $barang = $query->paginate(10)->appends($request->all());

        $kategori = [
            'Cat',
            'Semen',
            'Perkakas',
            'Kayu',
            'Gypsum',
            'Besi',
            'Keramik',
            'Material',
            'Alat Bantu',
            'Pelapis',
            'Perekat'
        ];

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
            'nama_barang.required' => 'Nama barang tidak boleh kosong.',
            'nama_barang.unique' => 'Barang telah tersedia.',
            'nama_barang.max' => 'Nama barang lebih dari 255 karakter',
            'kategori.required' => 'Kategori wajib diisi.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'stok.integer' => 'Stok harus berupa angka.',
            'satuan.required' => 'Satuan wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
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
            'nama_barang.required' => 'Nama barang tidak boleh kosong.',
            'nama_barang.unique' => 'Barang telah tersedia.',
            'nama_barang.max' => 'Nama barang lebih dari 255 karakter',
            'kategori.required' => 'Kategori wajib diisi.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'stok.integer' => 'Stok harus berupa angka.',
            'satuan.required' => 'Satuan wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
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

    public function addStok(Request $request, $id_barang)
    {
        // Validasi
        $request->validate([
            'nama_barang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('barang')->ignore($id_barang, 'id_barang'),
            ],
            'stok' => 'required|integer',
        ], [
            'nama_barang.required' => 'Nama barang tidak boleh kosong.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'stok.integer' => 'Stok harus berupa angka.',
        ]);

        // Update data
        $barang = Barang::findOrFail($id_barang);
        $barang->stok += $request->stok;
        $barang->save();

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

    public function cetak(Request $request)
    {
        $nama = $request->input('nama');
        $kategori = $request->input('kategori');
        $filterStok = $request->input('filter_stok');

        $barang = Barang::query()
            ->when($nama, function ($query) use ($nama) {
                return $query->where('nama_barang', 'like', '%' . $nama . '%');
            })
            ->when($kategori, function ($query) use ($kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($filterStok == 'minimum', function ($query) {
                return $query->where('stok', '<', 50);
            })
            ->orderBy('id_barang', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.pdfBarang', [
            'barang' => $barang,
            'nama' => $nama,
            'kategori' => $kategori,
            'filter_stok' => $filterStok,
        ]);

        return $pdf->stream('laporan-barang.pdf');
    }


    public function export(Request $request)
    {
        return Excel::download(
            new BarangExport(
                $request->nama,
                $request->kategori,
                $request->filter_stok // pastikan key-nya sesuai dengan form
            ),
            'data-barang.xlsx'
        );
    }
}