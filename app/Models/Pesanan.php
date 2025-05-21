<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    // Set nama tabel
    protected $table = 'pesanan';
    
    // Set primary key
    protected $primaryKey = 'id_pesanan';
    
    // Set timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // Set fillable columns
    protected $fillable = [
        'total_harga',
        'id_pelanggan',
    ];

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }
    public function Pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
