<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $keyType = 'string';
    protected $primaryKey = 'id_toko';

    protected $fillable = ['id_toko', 'sales', 'foto_toko', 'nama_toko', 'pemilik', 'foto_ktp', 'alamat', 'nomor_tlp', 'koordinat'];

}
