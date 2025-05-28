<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    // Set nama tabel
    protected $table = 'detail_pesanan';
    
    // Set primary key
    protected $primaryKey = 'id_detail_pesanan';
    
    // Set timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // Set fillable columns
    protected $fillable = [
        'jumlah',
        'harga',
        'id_barang',
        'kode_pesanan'
    ];

    // Relasi ke pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'kode_pesanan', 'kode_pesanan');
    }
    
    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
