<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\JenisSeeder;

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
            JenisSeeder::class,

        ]);
        // User::factory(10)->create();
    }
}
