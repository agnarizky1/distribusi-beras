<?php

namespace App\Models;

use App\Models\Beras;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id_grade';

    // public function grade()
    //     {
    //         return $this->hasMany(Beras::class, 'beras_id');
    //     }
}
