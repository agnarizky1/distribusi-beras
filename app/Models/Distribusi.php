<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    use HasFactory;

    protected $table = 'distribusis'; // Nama tabel dalam basis data

    protected $primaryKey = 'id_distribusi'; // Kolom primary key

    protected $fillable = [
        'id_toko',
        'kode_distribusi',
        'nama_sopir',
        'plat_no',
        'tanggal_distribusi',
        'jumlah_distribusi',
        'total_harga',
        'status',
    ];

    public function detailDistribusi()
    {
        return $this->hasMany(DetailDistribusi::class, 'id_distribusi');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_distribusi', 'id_distribusi');
    }
}
