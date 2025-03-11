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
                'icon' => 'LayoutGrid',
            ],
            [
                'title' => 'Inventory Location',
                'url' => '/inventory_location',
                'icon' => 'Folder',
            ]
        ];
        
        // Add more items based on permissions
        
        return $items;
    }
}