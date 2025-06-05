<?php

namespace App\Exports;

use App\Models\Pembelian;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembelianExport implements FromCollection, WithHeadings
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection()
    {
        $query = Pembelian::with('pemasok');

        if ($this->dateFrom && $this->dateTo) {
            $query->whereBetween('tanggal', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ]);
        }

        return $query->orderBy('tanggal', 'desc')->get()->map(function($pembelian) {
            return [
                'Kode Pembelian' => $pembelian->kode_pembelian,
                'Tanggal' => Carbon::parse($pembelian->tanggal)->format('d/m/Y'),
                'Pemasok' => $pembelian->pemasok->nama_pemasok ?? '-',
                'Total' => number_format($pembelian->total_harga, 2, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Kode Pembelian', 'Tanggal', 'Pemasok', 'Total'];
    }
}