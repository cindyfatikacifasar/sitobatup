<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@sitobat.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '081234567890',
        ]);

        User::create([
            'name'     => 'Ners Riani, S.Kep., M.Kes',
            'email'    => 'pj@sitobat.com',
            'password' => Hash::make('pj12345'),
            'role'     => 'penanggungjawab',
            'phone'    => '082345678901',
        ]);
    }
}