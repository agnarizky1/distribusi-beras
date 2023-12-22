<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\models\Toko;
use App\models\Sales;
use Illuminate\Support\Facades\DB;

class TokoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 5; $i++) {
            $prefix = 'T-';
            $lastId = Toko::max('id_toko');
            $allSales = Sales::all();
            $randomSales = $allSales->random();

            $nmSales = $randomSales->nama_sales;

            if (!$lastId) {
                // Jika belum ada data, gunakan nomor 1
                $nextId = $prefix . '00001';
            } else {
                // Ambil angka dari ID terakhir, tambahkan 1, dan lakukan padding
                $lastNumber = intval(substr($lastId, strlen($prefix))) + 1;
                $nextId = $prefix . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
            }

            // Generate nama file gambar untuk 'foto_toko' dan 'foto_ktp'
            $fotoToko = $faker->image('public/uploads/toko', 400, 300, null, false);
            $fotoKTP = $faker->image('public/uploads/ktp', 400, 300, null, false);

            // Generate koordinat dengan nilai acak
            $latitude = $faker->latitude;
            $longitude = $faker->longitude;

            DB::table('tokos')->insert([
                'id_toko' => $nextId,
                'foto_toko' => $fotoToko,
                'nama_toko' => $faker->company,
                'sales' => $nmSales,
                'pemilik' => $faker->name,
                'foto_ktp' => $fotoKTP,
                'alamat' => $faker->address,
                'nomor_tlp' => $faker->phoneNumber,
                'koordinat' => "$latitude, $longitude",
            ]);
        }
    }
}
