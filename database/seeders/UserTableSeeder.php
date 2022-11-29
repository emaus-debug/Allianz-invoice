<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            
            // Admin
            [
                'full_name' => 'Dora Maniquant',
                'username' => 'Admin',
                'email' => 'doramaniquant@gmail.com',
                'password' => Hash::make('admindora'),
                'role' => 'admin',
                'status' => 'active',
            ],

            // Employee
            [
                'full_name' => 'Dora Exploratrice',
                'username' => 'Employe',
                'email' => 'doraville@gmail.com',
                'password' => Hash::make('employedora'),
                'role' => 'employe',
                'status' => 'active',
            ],
        ]);
    }
}
