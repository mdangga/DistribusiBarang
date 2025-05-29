<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasok';
    protected $fillable = [
        'nama_pemasok',
        'alamat',
        'no_telpon'
    ];
    protected $primaryKey = 'id_pemasok';
    public $incrementing = true;
    protected $keyType = 'int';

    public function Pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_pemasok', 'id_pemasok');
    }
}
