<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDistribusi extends Model
{
    use HasFactory;

    protected $table = 'detail_distribusi'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_detail_distribusi'; // Kolom primary key
    protected $fillable = [
        'id_distribusi',
        'nama_beras',
        'jenis_beras',
        'harga',
        'jumlah_beras',
        'sub_total',
    ];

    public function distribusi()
    {
        return $this->belongsTo(Distribusi::class, 'id_distribusi');
    }
}
