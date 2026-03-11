<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kategori yang sudah dibuat
        $lighting  = Category::where('name', 'Smart Lighting')->first();
        $security  = Category::where('name', 'Smart Security')->first();
        $speaker   = Category::where('name', 'Smart Speaker')->first();
        $sensor    = Category::where('name', 'Smart Sensor')->first();

        $products = [
            [
                'category_id' => $lighting->id,
                'name'        => 'Philips Hue White',
                'description' => 'Lampu LED pintar 9W yang bisa dikontrol via app Philips Hue',
                'price'       => 299000,
                'stock'       => 50,
            ],
            [
                'category_id' => $lighting->id,
                'name'        => 'Xiaomi Smart Bulb',
                'description' => 'Bohlam pintar dengan 16 juta pilihan warna',
                'price'       => 189000,
                'stock'       => 75,
            ],
            [
                'category_id' => $security->id,
                'name'        => 'Xiaomi CCTV 360°',
                'description' => 'Kamera keamanan indoor 1080p dengan night vision',
                'price'       => 450000,
                'stock'       => 30,
            ],
            [
                'category_id' => $security->id,
                'name'        => 'Smart Door Lock',
                'description' => 'Kunci pintu pintar dengan fingerprint & PIN',
                'price'       => 1250000,
                'stock'       => 20,
            ],
            [
                'category_id' => $speaker->id,
                'name'        => 'Google Nest Mini',
                'description' => 'Smart speaker dengan Google Assistant',
                'price'       => 799000,
                'stock'       => 25,
            ],
            [
                'category_id' => $sensor->id,
                'name'        => 'Xiaomi Temperature Sensor',
                'description' => 'Sensor suhu dan kelembaban untuk rumah pintar',
                'price'       => 129000,
                'stock'       => 100,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $product['category_id'],
                'name'        => $product['name'],
                'slug'        => Str::slug($product['name']),
                'description' => $product['description'],
                'price'       => $product['price'],
                'stock'       => $product['stock'],
                'is_active'   => true,
            ]);
        }

        echo "✅ Produk berhasil dibuat!\n";
    }
}