<?php

namespace Database\Seeders;

use App\Models\Sales;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        foreach (range(1, 5) as $index) {
            Sales::create([
                'nama_sales' => $faker->name,
                'no_telpon' => $faker->phoneNumber,
            ]);
        }
    }

}
