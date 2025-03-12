<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryLocationController extends ResourceController
{
    //
    protected $tableHeader = [
        [
            "title" => "Inventory Location",
            "column" => "invt_loc_name",
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
        ],
    ];
    
    protected $formFields = [
        [
            "type" => "text",
            "label" => "Inventory Location",
            "name" => "invt_loc_name",
            "placeholder" => "Inventory Location",
            "required" => true,
        ],
    ];
}
