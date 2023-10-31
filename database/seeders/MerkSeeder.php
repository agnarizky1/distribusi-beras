<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Merk;

class MerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merk = [
            [
                'merk' => 'Jempol',
            ],
            [
                'merk' => 'Wangi',
            ],
            [
                'merk' => 'Dua Anak',
            ],
            [
                'merk' => 'Ratu',
            ],
            [
                'merk' => 'Gajah',
            ],

        ];
        Merk::insert($merk);
    }
}
