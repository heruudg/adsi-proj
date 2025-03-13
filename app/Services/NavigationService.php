<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class NavigationService
{
    public function getMainNavItems()
    {
        $user = Auth::user();
        $items = [
            // Add items that everyone can see
            [
                'title' => 'Dashboard',
                'url' => '/dashboard',
                'icon' => 'LayoutGrid',
            ],
            [
                'title' => 'Product',
                'url' => '/product',
                'icon' => 'Package',
            ],
            [
                'title' => 'Inventory Location',
                'url' => '/inventory_location',
                'icon' => 'MapPin',
            ],
            [
                'title' => 'Bill of Materials',
                'url' => '/bill_of_material',
                'icon' => 'FileText',
            ],
            [
                'title' => 'Manufacturing Order',
                'url' => '/manufacturing_order',
                'icon' => 'Clipboard',
            ],
            [
                'title' => 'Manufacturing Status',
                'url' => '/manufacturing_status',
                'icon' => 'Activity',
            ],
            [
                'title' => 'Raw Material',
                'url' => '/raw_material',
                'icon' => 'Box',
            ],
            [
                'title' => 'Work Center',
                'url' => '/work_center',
                'icon' => 'Factory',
            ],
            [
                'title' => 'User',
                'url' => '/user',
                'icon' => 'User',
            ],
            
        ];
        
        // Add more items based on permissions
        
        return $items;
    }
}