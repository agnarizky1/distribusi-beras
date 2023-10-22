<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $user = [
            // SuperAdmin
            [
                'name'            => 'superadmin',
                'email'          => 'superadmin@gmail.com',
                'password' => bcrypt('1'),
                'role' => 'superadmin',
            ],
            //Admin
            [
                'name'            => 'admin',
                'email'          => 'admin@gmail.com',
                'password' => bcrypt('1'),
                'role' => 'admin',
            ],
        ];
        User::insert($user);
    }

}
