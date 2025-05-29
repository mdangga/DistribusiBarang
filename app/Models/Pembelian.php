<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class Pembelian extends Model
{
    // Set nama tabel
    protected $table = 'pembelian';
    // Set primary key
    public $incrementing = false;
    protected $primaryKey = 'kode_pembelian';
    protected $keyType = 'string';

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $tanggalHariIni = Carbon::now()->format('dmY');
            $hitungPesananHariIni = DB::table('pembelian')->whereDate('tanggal', Carbon::today())->count();
            $nomorPembelian = str_pad($hitungPesananHariIni + 1, 4, '0', STR_PAD_LEFT);

            $model->kode_pembelian = "PMB-{$tanggalHariIni}-{$nomorPembelian}";
        });
    }
    
    // Set timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // Set fillable columns
    protected $fillable = [
        'tanggal',
        'id_pemasok',
        'total_harga'
    ];

    public function Pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok', 'id_pemasok');
    }
}
