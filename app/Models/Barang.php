<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'nama_barang', // Tambahkan ini
        'kategori',
        'stok',
        'satuan',
        'harga'
    ];
    protected $primaryKey = 'id_barang'; // Sesuaikan dengan nama kolom PK di database
    public $incrementing = true; // Pastikan ini true jika PK auto-increment
    protected $keyType = 'int'; // Sesuaikan tipe data PK
}
