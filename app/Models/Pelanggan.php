<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'no_telpon'
    ];
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = true;
    protected $keyType = 'int';

    public function Pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
