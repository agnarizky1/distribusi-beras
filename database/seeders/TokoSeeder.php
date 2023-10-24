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
                'id_toko' => 'TOKO001',
                'nama_toko' => 'Toko A',
                'pemilik' => 'Pemilik A',
                'alamat' => 'Alamat A',
                'nomor_tlp' => '1234567890',
            ],
            [
                'id_toko' => 'TOKO002',
                'nama_toko' => 'Toko B',
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

