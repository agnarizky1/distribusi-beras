<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class totalStock extends Model
{
    use HasFactory;
    protected $table = 'total_stocks';
    protected $fillable = ['merk_beras', 'ukuran_beras', 'jenis_beras', 'grade_beras', 'harga', 'jumlah_stock'];

}
