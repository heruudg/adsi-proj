<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RawMaterialController extends ResourceController
{
    //
    protected $tableHeader = [
        [
            "title" => "Raw Material Name",
            "column" => "material_name",
        ],
        [
            "title" => "Inventory Location",
            "column" => "inventory_location.invt_loc_name",
        ],
        [
            "title" => "Raw Material Quantity",
            "column" => "material_quantity",
        ],
        [
            "title" => "Raw Material UOM",
            "column" => "material_uom",
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
            "type" => "text",
            "label" => "Raw Material Name",
            "name" => "material_name",
            "placeholder" => "Raw Material Name",
            "required" => true,
        ],
        [
            "type" => "select",
            "label" => "Inventory Location",
            "name" => "invt_loc_name",
            "placeholder" => "Inventory Location",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "number",
            "label" => "Raw Material Quantity",
            "name" => "material_quantity",
            "placeholder" => "Raw Material Quantity",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "Raw Material UOM",
            "name" => "material_uom",
            "placeholder" => "Raw Material UOM",
            "required" => true,
        ],
    ];
    protected function getFormFields(){ 
        
        $this->formFields[1]['options'] = \App\Models\InventoryLocation::all()->map(function($item){
            return [
                'value' => $item->invt_loc_id,
                'label' => $item->invt_loc_name,
            ];
        });
        return $this->formFields;
    }

    protected $with = ['inventoryLocation'];
}
