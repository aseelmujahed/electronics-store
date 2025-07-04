<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Product::create([
            'name' => 'Gaming Headset',
            'description' => 'Immersive sound with noise cancellation.',
            'price' => 120,
            'image' => 'https://d3m9l0v76dty0.cloudfront.net/system/photos/12664924/large/1b153cb43795edc32ed3f91b84dc7f47.png',
            'tenant_id' => 'store1'

        ]);

        \App\Models\Product::create([
            'name' => 'Bluetooth Speaker',
            'description' => 'High quality sound.',
            'price' => 100,
            'image' => 'https://krisons.in/cdn/shop/files/71_ISrP3v6L._SL1500.jpg?v=1719565495',
            'tenant_id' => 'store2'
        ]);

        \App\Models\Product::create([
            'name' => 'Wireless Mouse',
            'description' => 'Very comfortable for daily use.',
            'price' => 50,
            'image' => 'https://www.bhphotovideo.com/images/images2500x2500/logitech_910_004277_m310_xl_wireless_mouse_1413247.jpg',
            'tenant_id' => 'store1'
        ]);

        \App\Models\Product::create([
            'name' => 'Smart Watch',
            'description' => 'Track your fitness and notifications on the go.',
            'price' => 300,
            'image' => 'https://goldtop.co.il/upload_files/FITPRO%20S3%20PROMO.jpg',
            'tenant_id' => 'store1'
        ]);

        \App\Models\Product::create([
            'name' => 'Wireless Charger',
            'description' => '10W fast wireless charging pad for smartphones.',
            'price' => 100,
            'image' => 'https://images.mobilefun.co.uk/graphics/450pixelp/94937.jpg',
            'tenant_id' => 'store2'
        ]);

        \App\Models\Product::create([
            'name' => 'Action Camera',
            'description' => '4K waterproof sports action camera with accessories.',
            'price' => 350,
            'image' => 'https://static.gopro.com/assets/blta2b8522e5372af40/blt304330c107f108f1/66a7ddf20ccb2fe4e47ff6ae/04-2-clp-featured-Hero-1024-375-png.png',
            'tenant_id' => 'store2'
        ]);
    }
}
