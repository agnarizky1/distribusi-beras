<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
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
                'grade' => 'GRADE A',
            ],
            [
                'grade' => 'GRADE A-',
            ],
            [
                'grade' => 'GRADE B',
            ],
            [
                'grade' => 'GRADE C',
            ],
            [
                'grade' => 'REJECT A',
            ],
            [
                'grade' => 'REJECT B',
            ],
            [
                'grade' => 'REJECT C',
            ],

        ];
        Grade::insert($grade);
    }
}
