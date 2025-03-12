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
    ];

    protected $with = ['inventoryLocation'];
}
