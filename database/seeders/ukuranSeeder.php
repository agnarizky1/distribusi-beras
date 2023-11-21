<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Ukuran;


class ukuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ukuran = [
            [
                'berat' => '2.5',
            ],
            [
                'berat' => '3',
            ],
            [
                'berat' => '5',
            ],
            [
                'berat' => '10',
            ],
            [
                'berat' => '25',
            ],
        ];
        Ukuran::insert($ukuran);
    }
}
