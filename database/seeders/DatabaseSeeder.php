<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => Faker::create()->name,
            'email' => Faker::create()->unique()->safeEmail,
        ]);
        
        // Add the roles and permissions seeder
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Run seeders in the correct order (dependencies first)
        $this->call([
            InventoryLocationSeeder::class,
            WorkCenterSeeder::class,
            ManufacturingStatusSeeder::class,
            ProductSeeder::class,
            RawMaterialSeeder::class,
            BillOfMaterialSeeder::class,
            ManufacturingOrderSeeder::class,
        ]);
    }
}
