<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\BillOfMaterialItemFactory;
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

        // Add the roles and permissions seeder
        $this->call(RolesAndPermissionsSeeder::class);
        
        $roles = ['admin','inventory-staff', 'production-staff'];

        foreach ($roles as $key => $role) {
            $user = User::factory()->create([
                'name' => Faker::create()->name,
                'email' => "{$role}@example.com",
            ]);
            $user->assignRole($role);
        }
        
        
        // Run seeders in the correct order (dependencies first)
        $this->call([
            InventoryLocationSeeder::class,
            WorkCenterSeeder::class,
            ManufacturingStatusSeeder::class,
            ProductSeeder::class,
            RawMaterialSeeder::class,
            BillOfMaterialSeeder::class,
            ManufacturingOrderSeeder::class,
            BillOfMaterialItemSeeder::class,
        ]);
    }
}
