<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = [
            [
                'jenis' => 'IR64',
            ],
            [
                'jenis' => 'PANDAN WANGI',
            ],
            [
                'jenis' => 'LEGOWO',
            ],
            [
                'jenis' => 'GRADE C',
            ],
            [
                'jenis' => 'GH',
            ],

        ];
        Jenis::insert($jenis);
    }
}
