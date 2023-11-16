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
            [
                'berat' => '50',
            ],
            [
                'berat' => '100',
            ],
        ];
        Ukuran::insert($ukuran);
    }
}
