<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Smart Lighting',
                'description' => 'Lampu pintar yang bisa dikontrol via smartphone',
            ],
            [
                'name'        => 'Smart Security',
                'description' => 'Perangkat keamanan rumah pintar seperti CCTV dan smart lock',
            ],
            [
                'name'        => 'Smart Speaker',
                'description' => 'Speaker pintar dengan asisten suara',
            ],
            [
                'name'        => 'Smart Sensor',
                'description' => 'Sensor suhu, gerak, dan kelembaban untuk rumah pintar',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }

        echo "✅ Kategori berhasil dibuat!\n";
    }
}