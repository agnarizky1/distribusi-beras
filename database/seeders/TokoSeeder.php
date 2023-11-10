<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Toko;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TokoSeeder extends Seeder
{
    public function run(){
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 100; $i++) {
            $prefix = 'T-';
            $lastId = Toko::max('id_toko');

            if (!$lastId) {
                $nextId = $prefix . '00001';
            } else {
                $lastNumber = intval(substr($lastId, strlen($prefix))) + 1;
                $nextId = $prefix . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
            }

            DB::table('tokos')->insert([
                'id_toko' => $nextId,
                'nama_toko' => $faker->company,
                'grade_toko' => 'BIASA',
                'pemilik' => $faker->name,
                'alamat' => $faker->address,
                'nomor_tlp' => $faker->phoneNumber,
            ]);
        }
    }
}

