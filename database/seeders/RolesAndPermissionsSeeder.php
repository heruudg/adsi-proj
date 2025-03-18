<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Raw Material Permissions
        $rawMaterialPermissions = [
            'add-raw-material',
            'view-raw-material',
            'update-raw-material',
            'delete-raw-material',
        ];

        // Product Permissions
        $productPermissions = [
            'add-product',
            'view-product',
            'update-product',
            'delete-product',
        ];

        // Inventory Location Permissions
        $inventoryLocationPermissions = [
            'add-inventory-location',
            'view-inventory-location',
            'update-inventory-location',
            'delete-inventory-location',
        ];

        // Bill of Material Permissions
        $billOfMaterialPermissions = [
            'create-bill-of-material',
            'view-bill-of-material',
            'update-bill-of-material',
            'delete-bill-of-material',
        ];

        // Work Center Permissions
        $workCenterPermissions = [
            'create-work-center',
            'view-work-center',
            'update-work-center',
            'delete-work-center',
        ];

        // Manufacturing Order Permissions
        $manufacturingOrderPermissions = [
            'create-manufacturing-order',
            'start-manufacturing-order',
            'finish-manufacturing-order',
            'cancel-manufacturing-order',
        ];

        // Manufacturing Status Permissions
        $manufacturingStatusPermissions = [
            'add-manufacturing-status',
            'update-manufacturing-status',
            'view-manufacturing-status',
            'delete-manufacturing-status',
        ];

        // Auth Permissions
        $authPermissions = [
            'register',
            'login',
        ];

        // Create permissions
        $allPermissions = array_merge(
            $rawMaterialPermissions,
            $productPermissions,
            $inventoryLocationPermissions,
            $billOfMaterialPermissions,
            $workCenterPermissions,
            $manufacturingOrderPermissions,
            $manufacturingStatusPermissions,
            $authPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $inventoryStaffRole = Role::create(['name' => 'inventory-staff']);
        $inventoryStaffRole->givePermissionTo([
            // Raw Material
            'add-raw-material',
            'view-raw-material',
            'update-raw-material',
            'delete-raw-material',
            // Product
            'add-product',
            'view-product',
            'update-product',
            'delete-product',
            // Inventory Location
            'add-inventory-location',
            'view-inventory-location',
            'update-inventory-location',
            'delete-inventory-location',
            // Bill of Material
            'create-bill-of-material',
            'view-bill-of-material',
            'update-bill-of-material',
            'delete-bill-of-material',
            // Auth
            'register',
            'login',
        ]);

        $productionStaffRole = Role::create(['name' => 'production-staff']);
        $productionStaffRole->givePermissionTo([
            // Work Center
            'create-work-center',
            'view-work-center',
            'update-work-center',
            'delete-work-center',
            // Manufacturing Order
            'create-manufacturing-order',
            'start-manufacturing-order',
            'finish-manufacturing-order',
            'cancel-manufacturing-order',
            // Manufacturing Status
            'add-manufacturing-status',
            'update-manufacturing-status',
            'view-manufacturing-status',
            'delete-manufacturing-status',
            // View Only Permissions
            'view-raw-material',
            'view-product',
            'view-bill-of-material',
            // Auth
            'register',
            'login',
        ]);

        // Create Super Admin role with all permissions
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Create demo users and assign roles
        $inventoryUser = User::factory()->create([
            'name' => 'Inventory Staff',
            'email' => 'inventory@example.com',
        ]);
        $inventoryUser->assignRole('inventory-staff');

        $productionUser = User::factory()->create([
            'name' => 'Production Staff',
            'email' => 'production@example.com',
        ]);
        $productionUser->assignRole('production-staff');

        $adminUser = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
        ]);
        $adminUser->assignRole('super-admin');
    }
}