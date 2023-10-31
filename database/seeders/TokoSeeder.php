<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Toko;

class TokoSeeder extends Seeder
{
    public function run()
    {
        // Data toko yang akan diisi ke tabel 'tokos'
        $data = [
            [
                'id_toko' => 'T-00001',
                'nama_toko' => 'Toko A',
                'grade_toko' => 'BIASA',
                'pemilik' => 'Pemilik A',
                'alamat' => 'Alamat A',
                'nomor_tlp' => '1234567890',
            ],
            [
                'id_toko' => 'T-00002',
                'nama_toko' => 'Toko B',
                'grade_toko' => 'BIASA',
                'pemilik' => 'Pemilik B',
                'alamat' => 'Alamat B',
                'nomor_tlp' => '0987654321',
            ],
            // Tambahkan data toko lainnya sesuai kebutuhan
        ];

        // Masukkan data ke tabel 'tokos'
        Toko::insert($data);
    }
}

