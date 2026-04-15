<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Cafe Kopitiam33',
            'email' => 'admin@kopitiam33.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        
        echo "Admin berhasil dibuat!\n";
        echo "Email: admin@kopitiam33.id\n";
        echo "Password: admin123\n";
    }
}