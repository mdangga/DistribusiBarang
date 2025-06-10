<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pesanan extends Model
{
    use HasFactory;

    // Set nama tabel
    protected $table = 'pesanan';
    // Set primary key
    public $incrementing = false;
    protected $primaryKey = 'kode_pesanan';
    protected $keyType = 'string';

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $tanggalHariIni = Carbon::now()->format('dmY');
            $hitungPesananHariIni = DB::table('pesanan')->whereDate('tanggal', Carbon::today())->count();
            $nomorPesanan = str_pad($hitungPesananHariIni + 1, 4, '0', STR_PAD_LEFT);

            $model->kode_pesanan = "PSN-{$tanggalHariIni}-{$nomorPesanan}";
        });
    }

    // Set timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // Set fillable columns
    protected $fillable = [
        'total_awal',
        'total_diskon',
        'total_pajak',  
        'total_harga',
        'id_pelanggan',
        'tanggal',
    ];

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'kode_pesanan', 'kode_pesanan');
    }
    public function Pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
