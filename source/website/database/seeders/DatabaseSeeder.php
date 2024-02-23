<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Joel Oliveira',
            'email' => 'joeloliveira@oriworks.com',
        ]);

        $tenant = \App\Models\Central\Tenant::create([
            'id' => 'padel',
            'tenancy_db_connection' => 'padel',
            'tenancy_db_driver' => 'mysql',
            'tenancy_db_host' => '172.18.0.1',
            'tenancy_db_port' => '33061',
            'tenancy_db_name' => 'padel_switch_ctrl',
            'tenancy_db_password' => 'root',
            'tenancy_db_username' => 'root',
            'features_blog' => false,
        ]);
        $tenant->domains()->create([
            'domain' => 'padel.switch-ctrl.local',
        ]);
    }
}
