<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    protected $nama;
    protected $kategori;
    protected $filterStok;

    public function __construct($nama, $kategori, $filterStok)
    {
        $this->nama = $nama;
        $this->kategori = $kategori;
        $this->filterStok = $filterStok;
    }

    public function collection()
    {
        $query = Barang::query();

        if ($this->nama) {
            $query->where('nama_barang', 'like', '%' . $this->nama . '%');
        }

        if ($this->kategori) {
            $query->where('kategori', $this->kategori);
        }

        if ($this->filterStok === 'minimum') {
            $query->where('stok', '<', 50);
        }

        return $query->get()->map(function ($item, $index) {
            return [
                'ID' => 'BRG' . str_pad($item->id_barang, 3, '0', STR_PAD_LEFT),
                'Nama Barang' => $item->nama_barang,
                'Kategori' => $item->kategori,
                'Stok' => $item->stok,
                'Satuan' => $item->satuan,
                'Harga' => $item->harga,
            ];
        });

    }
    public function headings(): array
    {
        return ['ID', 'Nama Barang', 'Kategori', 'Stok', 'Satuan', 'Harga'];
    }

}