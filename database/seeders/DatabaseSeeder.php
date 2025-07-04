<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Aseel',
            'email' => 'aseelmujahed@gmail.com',
            'password' => bcrypt('aseelmujahed'),
            'tenant_id' => 'store1',
        ]);
        User::factory()->create([
            'name' => 'Admin store1',
            'email' => 'adminstore1@gmail.com',
            'password' => bcrypt('adminstore1'),
            'tenant_id' => 'store1',
            'role' => 'admin',
        ]);
         User::factory()->create([
            'name' => 'Admin store2',
            'email' => 'adminstore2@gmail.com',
            'password' => bcrypt('adminstore2'),
            'tenant_id' => 'store2',
            'role' => 'admin',
        ]);
        $this->call(ProductSeeder::class);
        $this->call(TenantSeeder::class);
    }
}
