<?php

namespace App\Exports;

use App\Models\Pesanan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PesananExport implements FromCollection, WithHeadings
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
        $query = Pesanan::with('pelanggan')->has('detailPesanan');

        if ($this->dateFrom && $this->dateTo) {
            $query->whereBetween('tanggal', [
                Carbon::parse($this->dateFrom)->startOfDay(),
                Carbon::parse($this->dateTo)->endOfDay()
            ]);
        }

        return $query->orderBy('tanggal', 'desc')->get()->map(function($pesanan) {
            return [
                'Kode Pesanan' => $pesanan->kode_pesanan,
                'Tanggal' => Carbon::parse($pesanan->tanggal)->format('d/m/Y'),
                'Pelanggan' => $pesanan->pelanggan->nama_pelanggan ?? '-',
                'Total Harga' => number_format($pesanan->total_harga, 2, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Kode Pesanan', 'Tanggal', 'Pelanggan', 'Total Harga'];
    }
}