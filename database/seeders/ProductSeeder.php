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
            'image' => 'https://d3m9l0v76dty0.cloudfront.net/system/photos/12664924/large/1b153cb43795edc32ed3f91b84dc7f47.png'

        ]);

        \App\Models\Product::create([
            'name' => 'Bluetooth Speaker',
            'description' => 'High quality sound.',
            'price' => 100,
            'image' => 'https://tse1.explicit.bing.net/th/id/OIP.Y9GIzpKsNWWfjZffAqcs3AHaHa?rs=1&pid=ImgDetMain&o=7&rm=3'
        ]);

        \App\Models\Product::create([
            'name' => 'Wireless Mouse',
            'description' => 'Very comfortable for daily use.',
            'price' => 50,
            'image' => 'https://www.bhphotovideo.com/images/images2500x2500/logitech_910_004277_m310_xl_wireless_mouse_1413247.jpg'
        ]);

        \App\Models\Product::create([
            'name' => 'Smart Watch',
            'description' => 'Track your fitness and notifications on the go.',
            'price' => 300,
            'image' => 'https://goldtop.co.il/upload_files/FITPRO%20S3%20PROMO.jpg'
        ]);

        \App\Models\Product::create([
            'name' => 'Wireless Charger',
            'description' => '10W fast wireless charging pad for smartphones.',
            'price' => 100,
            'image' => 'https://images.mobilefun.co.uk/graphics/450pixelp/94937.jpg'
        ]);

        \App\Models\Product::create([
            'name' => 'Action Camera',
            'description' => '4K waterproof sports action camera with accessories.',
            'price' => 350,
            'image' => 'https://static.gopro.com/assets/blta2b8522e5372af40/blt304330c107f108f1/66a7ddf20ccb2fe4e47ff6ae/04-2-clp-featured-Hero-1024-375-png.png'
        ]);
    }
}
