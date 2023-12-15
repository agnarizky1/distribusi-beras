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
        'kode_pengembalian',
        'id_distribusi',
        'tanggal_pengembalian',
        'jumlah_return',
        'uang_return',
    ];

    public function distribusi()
    {
        return $this->belongsTo(Distribusi::class, 'id_distribusi');
    }
}
