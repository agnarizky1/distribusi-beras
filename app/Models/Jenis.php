<?php

namespace App\Models;

use App\Models\Beras;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenis extends Model
{
    use HasFactory;
     protected $guarded = [];
     protected $primaryKey = 'id_jenis';
}
