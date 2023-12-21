<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalians'; 

    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'id_toko',
        'kode_pengembalian',
        'tanggal_pengembalian',
        'jumlah_return',
        'uang_return',
    ];

    public function detailPengembalian()
    {
        return $this->hasMany(DetailPengembalian::class, 'id_pengembalian');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }
}
