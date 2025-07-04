<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stancl\Tenancy\Database\Models\Tenant;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::firstOrCreate([
            'id' => 'store1',
        ], [
            'data' => json_encode([]), 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!DB::table('domains')->where('domain', 'store1.127.0.0.1')->exists()) {
            DB::table('domains')->insert([
                'domain' => 'store1.localhost',
                'tenant_id' => 'store1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $tenant2 = Tenant::firstOrCreate([
            'id' => 'store2',
        ], [
            'data' => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!DB::table('domains')->where('domain', 'store2.127.0.0.1')->exists()) {
            DB::table('domains')->insert([
                'domain' => 'store2.localhost',
                'tenant_id' => 'store2',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
