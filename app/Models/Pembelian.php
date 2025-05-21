<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    // Set nama tabel
    protected $table = 'pembelian';
    
    // Set primary key
    protected $primaryKey = 'id_pembelian';
    
    // Set timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // Set fillable columns
    protected $fillable = [
        'total_harga',
    ];
}
