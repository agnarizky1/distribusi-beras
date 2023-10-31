<?php

namespace Database\Seeders;

use Database\Seeders\Beras;
use Illuminate\Database\Seeder;
use Database\Seeders\TokoSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\JenisSeeder;
use Database\Seeders\GradeTokoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            GradeSeeder::class,
            GradeTokoSeeder::class,
            JenisSeeder::class,
            TokoSeeder::class,
            MerkSeeder::class,

        ]);
        // User::factory(10)->create();
    }
}
