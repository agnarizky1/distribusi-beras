<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Jenis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beras extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $keyType = 'string';
    protected $primaryKey = 'id_beras';

//     public function grade()
// {
//     return $this->belongsTo(Grade::class, 'id_grade');
// }

// public function jenis()
// {
//     return $this->belongsTo(Jenis::class, 'id_jenis');
// }

}


