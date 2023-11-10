<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\models\Toko;

class TokoSeeder extends Seeder
{
    public function run()
    {
    $faker = Faker::create('id_ID');

    for ($i = 0; $i < 100; $i++) {
        $prefix = 'T-';
        $lastId = Toko::max('id_toko');

        if (!$lastId) {
            // Jika belum ada data, gunakan nomor 1
            $nextId = $prefix . '00001';
        } else {
            // Ambil angka dari ID terakhir, tambahkan 1, dan lakukan padding
            $lastNumber = intval(substr($lastId, strlen($prefix))) + 1;
            $nextId = $prefix . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
        }

        \DB::table('tokos')->insert([
            'id_toko' => $nextId,
            'nama_toko' => $faker->company,
            'grade_toko' => 'BIASA',
            'pemilik' => $faker->name,
            'alamat' => $faker->address,
            'nomor_tlp' => $faker->phoneNumber,
            // Add other columns as needed
        ]);
     }
    }

}

