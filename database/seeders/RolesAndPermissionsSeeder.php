<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions

        // Create permissions for raw_material
        Permission::create(['name' => 'add-raw_material']);
        Permission::create(['name' => 'view-raw_material']);
        Permission::create(['name' => 'update-raw_material']);
        Permission::create(['name' => 'delete-raw_material']);

        // Create permissions for product
        Permission::create(['name' => 'add-product']);
        Permission::create(['name' => 'view-product']);
        Permission::create(['name' => 'update-product']);
        Permission::create(['name' => 'delete-product']);

        // Create permissions for inventory_location
        Permission::create(['name' => 'add-inventory_location']);
        Permission::create(['name' => 'view-inventory_location']);
        Permission::create(['name' => 'update-inventory_location']);
        Permission::create(['name' => 'delete-inventory_location']);

        // Create permissions for bill_of_materials
        Permission::create(['name' => 'create-bill_of_materials']);
        Permission::create(['name' => 'view-bill_of_materials']);
        Permission::create(['name' => 'update-bill_of_materials']);
        Permission::create(['name' => 'delete-bill_of_materials']);

        // Create permissions for work_center
        Permission::create(['name' => 'create-work_center']);
        Permission::create(['name' => 'view-work_center']);
        Permission::create(['name' => 'update-work_center']);
        Permission::create(['name' => 'delete-work_center']);

        // Create permissions for manufacturing_order
        Permission::create(['name' => 'create-manufacturing_order']);
        Permission::create(['name' => 'start-manufacturing_order']);
        Permission::create(['name' => 'finish-manufacturing_order']);
        Permission::create(['name' => 'cancel-manufacturing_order']);

        // Create permissions for manufacturing_status
        Permission::create(['name' => 'add-manufacturing_status']);
        Permission::create(['name' => 'view-manufacturing_status']);
        Permission::create(['name' => 'update-manufacturing_status']);
        Permission::create(['name' => 'delete-manufacturing_status']);

        // Create permissions for authentication
        Permission::create(['name' => 'register-user']);
        Permission::create(['name' => 'login-user']);

        // Create roles and assign permissions
        $inventoryStaffRole = Role::create(['name' => 'inventory-staff']);
        $inventoryStaffRole->givePermissionTo([
            'add-raw_material',
            'view-raw_material',
            'update-raw_material',
            'delete-raw_material',
            'add-product',
            'view-product',
            'update-product',
            'delete-product',
            'add-inventory_location',
            'view-inventory_location',
            'update-inventory_location',
            'delete-inventory_location',
            'view-bill_of_materials',
            'view-work_center',
            'view-manufacturing_status',
            'login-user'
        ]);

        $productionStaffRole = Role::create(['name' => 'production-staff']);
        $productionStaffRole->givePermissionTo([
            'view-raw_material',
            'view-product',
            'view-inventory_location',
            'create-bill_of_material',
            'view-bill_of_material',
            'update-bill_of_material',
            'delete-bill_of_material',
            'create-work_center',
            'view-work_center',
            'update-work_center',
            'delete-work_center',
            'create-manufacturing_order',
            'start-manufacturing_order',
            'finish-manufacturing_order',
            'cancel-manufacturing_order',
            'add-manufacturing_status',
            'view-manufacturing_status',
            'update-manufacturing_status',
            'delete-manufacturing_status',
            'login-user'
        ]);


        // Admin role - gets all permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // Assign admin role to first user (if exists)
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }

        // Create more users and assign random roles
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        $roles = ['inventory-staff', 'production-staff'];

        foreach ($users as $user) {
            // Skip if the user already has the admin role
            if ($user->hasRole('admin')) {
                continue;
            }
            
            // Assign a random role to each user
            $randomRole = $roles[array_rand($roles)];
            $user->assignRole($randomRole);
            
            $this->command->info("Assigned role '{$randomRole}' to user: {$user->name}");
        }
    }
}