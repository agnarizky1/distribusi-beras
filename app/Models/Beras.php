<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beras extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $keyType = 'string';
    protected $primaryKey = 'id_beras';

    protected $fillable = [
        'id_beras',
        'merk_beras',
        'berat',
        'nama_sopir',
        'plat_no',
        'tanggal_masuk_beras',
        'harga',
        'stock',
        'keterangan',
    ];
}


