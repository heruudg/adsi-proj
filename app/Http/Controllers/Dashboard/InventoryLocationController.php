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
