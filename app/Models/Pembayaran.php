<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_distribusi',
    ];

    public function distribusi()
    {
        return $this->belongsTo(Distribusi::class, 'id_distribusi');
    }
}