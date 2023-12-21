<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    use HasFactory;
    protected $table = 'detail_pengembalians'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_detail_pengembalian'; // Kolom primary key
    protected $fillable = [
        'id_pengembalian',
        'nama_beras',
        'harga',
        'jumlah_beras',
        'sub_total',
        'return_toko',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian');
    }
}
