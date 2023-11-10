<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\models\Toko;

class TokoSeeder extends Seeder
{
    public function run()
    {
        $nm_toko = ['joyo', 'subur', 'makmur', 'sumber', 'rejeki', 'abadi', 'abadi', 'abdul', 'sari', 'tukul', 'jembar'];
        $pemilik = ['Joko', 'Nuha', 'Tun', 'Bon', 'Vander', 'Ado', 'Edi', 'Akil', 'Nimo', 'Senlong', 'Jupri'];
        $alamat = ['Sumbersari', 'Jl. Kalimantan', 'Jl. Sumatra', 'Kemiren', 'Rogojampi', 'Blimbingsari'];

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

            $tambah = [
                'id_toko' => $nextId,
                'nama_toko' => $nm_toko[mt_rand(0, 10)] . ' ' . $nm_toko[mt_rand(0, 10)],
                'grade_toko' => 'BIASA',
                'pemilik' => $pemilik[mt_rand(0, 10)],
                'alamat' => $alamat[mt_rand(0, 5)],
                'nomor_tlp' => '0812' . mt_rand(10000000, 99999999),
            ];

            Toko::insert($tambah);
            // $data[] = $tambah;
        }

        // foreach ($data as $item) {
        //     echo 'ID Toko: ' . $item['id_toko'] . ', Nama Toko: ' . $item['nama_toko'] . PHP_EOL;
        // }

        // Masukkan data ke tabel 'tokos'
        // Toko::insert($data);
    }
}

