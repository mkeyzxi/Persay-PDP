<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Akuntansi',
            'email' => 'akuntansi@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'akuntansi',

        ]);
        User::create([
            'name' => 'Admin Logistik',
            'email' => 'logistik@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'logistik',

        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',

        ]);
        User::create([
            'name' => 'Admin Konstruksi',
            'email' => 'konstruksi@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'konstruksi',

        ]);
    }
}
