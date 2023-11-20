<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Beras;
use App\Models\Ukuran;
use App\Models\Merk;
use App\Models\totalStock;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BerasSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $merk = Merk::all();
        $ukuran = Ukuran::all();

        $dataBeras = [];
        foreach ($merk as $m) {
            foreach ($ukuran as $u) {
                $prefix = 'B-';
                $lastId = Beras::max('id_beras');

                if (!$lastId) {
                    // Jika belum ada data, gunakan nomor 1
                    $nextId = $prefix . '00001';
                } else {
                    // Ambil angka dari ID terakhir, tambahkan 1, dan lakukan padding
                    $lastNumber = intval(substr($lastId, strlen($prefix))) + 1;
                    $nextId = $prefix . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
                }

                $beras = [
                    'id_beras' => $nextId,
                    'merk_beras' => $m->merk,
                    'berat' => $u->berat,
                    'nama_sopir' => $faker->name,
                    'plat_no' => $faker->bothify('??? ###'),
                    'tanggal_masuk_beras' => now(),
                    'harga' => 10000,
                    'stock' => 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $totalStock = [
                    'merk_beras' => $m->merk,
                    'ukuran_beras' => $u->berat,
                    'jumlah_stock' => $beras['stock'],
                    'harga' => 10000,
                ];

                Beras::insert($beras);
                totalStock::insert($totalStock);
                $dataBeras[] = $totalStock;
            }
        }
        // foreach ($dataBeras as $d) {
        //     echo implode(', ', $d) . "\n";
        // }
    }
}
