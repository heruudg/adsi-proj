<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends ResourceController
{
    //
    protected $tableHeader = [
        [
            "title" => "Inventory Location",
            "column" => "inventory_location.invt_loc_name",
        ],
        [
            "title" => "Product Name",
            "column" => "product_name",
        ],
        [
            "title" => "Product Quantity",
            "column" => "product_quantity",
        ],
        [
            "title" => "Product UOM",
            "column" => "product_uom",
        ],
        [
            "title" => "Created At",
            "column" => "created_at",
            "type" => "datetime",
        ],
        [
            "title" => "Updated At",
            "column" => "updated_at",
            "type" => "datetime",
        ]
    ];

    protected $formFields = [
        [
            "type" => "select",
            "label" => "Inventory Location",
            "name" => "invt_loc_name",
            "placeholder" => "Inventory Location",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "text",
            "label" => "Product Name",
            "name" => "product_name",
            "placeholder" => "Product Name",
            "required" => true,
        ],
        [
            "type" => "number",
            "label" => "Product Quantity",
            "name" => "product_quantity",
            "placeholder" => "Product Quantity",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "Product UOM",
            "name" => "product_uom",
            "placeholder" => "Product UOM",
            "required" => true,
        ],
    ];

    protected $with = ['inventoryLocation'];

    protected function getFormFields(){ 
        
        $this->formFields[0]['options'] = \App\Models\InventoryLocation::all()->map(function($item){
            return [
                'value' => $item->invt_loc_id,
                'label' => $item->invt_loc_name,
            ];
        });
        return $this->formFields;
    }
}
