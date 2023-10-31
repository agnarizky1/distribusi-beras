<?php

namespace Database\Seeders;

use App\Models\GradeToko;
use Illuminate\Database\Seeder;

class GradeTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade = [
            [
                'grade_toko' => 'BIASA',
            ],
            [
                'grade_toko' => 'SEDANG',
            ],
            [
                'grade_toko' => 'TERBAIK',
            ],

        ];
        GradeToko::insert($grade);
    }
}
