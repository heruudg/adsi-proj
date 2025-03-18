<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class NavigationService
{
    public function getMainNavItems()
    {
        $user = Auth::user();
        
        // Define all menu items with their required permissions
        $menuItems = [
            [
                'title' => 'Dashboard',
                'url' => '/dashboard',
                'icon' => 'LayoutGrid',
                'permissions' => [] // Everyone can see dashboard
            ],
            [
                'title' => 'Product',
                'url' => '/product',
                'icon' => 'Package',
                'permissions' => ['view-product']
            ],
            [
                'title' => 'Inventory Location',
                'url' => '/inventory_location',
                'icon' => 'MapPin',
                'permissions' => ['view-inventory-location'] // Changed from view-inventory_location
            ],
            [
                'title' => 'Bill of Materials',
                'url' => '/bill_of_material',
                'icon' => 'FileText',
                'permissions' => ['view-bill-of-material'] // Changed from view-bill_of_material
            ],
            [
                'title' => 'Manufacturing Order',
                'url' => '/manufacturing_order',
                'icon' => 'Clipboard',
                'permissions' => [
                    'create-manufacturing-order',
                    'start-manufacturing-order',
                    'finish-manufacturing-order',
                    'cancel-manufacturing-order'
                ] // Changed from manufacturing_order to manufacturing-order
            ],
            [
                'title' => 'Manufacturing Status',
                'url' => '/manufacturing_status',
                'icon' => 'Activity',
                'permissions' => ['view-manufacturing-status'] // Changed from view-manufacturing_status
            ],
            [
                'title' => 'Raw Material',
                'url' => '/raw_material',
                'icon' => 'Box',
                'permissions' => ['view-raw-material'] // Changed from view-raw_material
            ],
            [
                'title' => 'Work Center',
                'url' => '/work_center',
                'icon' => 'Factory',
                'permissions' => ['view-work-center'] // Changed from view-work_center
            ],
        ];

        // Filter menu items based on user permissions
        $filteredItems = [];
        
        foreach ($menuItems as $item) {
            // If there are no permissions required, add the item
            if (empty($item['permissions'])) {
                $filteredItems[] = [
                    'title' => $item['title'],
                    'url' => $item['url'],
                    'icon' => $item['icon'],
                ];
                continue;
            }
            
            // Check if the user has at least one of the required permissions
            foreach ($item['permissions'] as $permission) {
                if ($user->can($permission)) {
                    $filteredItems[] = [
                        'title' => $item['title'],
                        'url' => $item['url'],
                        'icon' => $item['icon'],
                    ];
                    break;
                }
            }
        }
        
        // If user is super-admin, add all menu items (changed from admin to super-admin)
        if ($user->hasRole('super-admin')) {
            $filteredItems = array_map(function ($item) {
                return [
                    'title' => $item['title'],
                    'url' => $item['url'],
                    'icon' => $item['icon'],
                ];
            }, $menuItems);
        }
        
        return $filteredItems;
    }
}