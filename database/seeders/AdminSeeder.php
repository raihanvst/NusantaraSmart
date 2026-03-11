<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin NusantaraSmart',
            'email'    => 'admin@nusantarasmart.com',
            'password' => Hash::make('admin123456'),
            'role'     => 'admin',
        ]);

        echo "✅ Akun admin berhasil dibuat!\n";
        echo "   Email    : admin@nusantarasmart.com\n";
        echo "   Password : admin123456\n";
    }
}