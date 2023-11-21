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
                'merk' => 'Jempol Enak',
            ],
            [
                'merk' => 'Jempol Mantap Plastik',
            ],
            [
                'merk' => 'Jempol Mantap Laminasi',
            ],
            [
                'merk' => 'Nis Manis',
            ],

        ];
        Merk::insert($merk);
    }
}
