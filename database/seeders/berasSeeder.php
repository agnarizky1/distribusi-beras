<?php

namespace Database\Seeders;

use App\Models\Beras;
use Illuminate\Database\Seeder;

class berasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $data = [
            [
                'id_beras'      => '21',
                'nama_beras'    => 'Jempol',
                'berat'         => 5,
                'jenis_beras'   => 'IR64',
                'grade_beras'   => 'A',
                'harga'         => 50000,
                'stock'         => 100,
            ],
            [
                'id_beras'      => '22',
                'nama_beras'    => 'Jempol',
                'berat'         => 3,
                'jenis_beras'   => 'IR64',
                'grade_beras'   => 'A',
                'harga'         => 30000,
                'stock'         => 100,
            ],
        ];
        Beras::insert($data);
    }

}
