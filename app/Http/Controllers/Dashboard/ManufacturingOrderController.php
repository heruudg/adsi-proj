<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManufacturingOrderController extends ResourceController
{
    //
    protected $tableHeader = [
        [
            "title" => "Bill of Materials",
            "column" => "bill_of_material.bom_name",
        ],
        [
            "title" => "Manufacturing Status",
            "column" => "manufacturing_status.mfg_stat_name",
        ],
        [
            "title" => "Manufacturing Qty",
            "column" => "prod_manufacture_qty",
        ],
        [
            "title" => "Start Date",
            "column" => "start_date",
            "type" => "date",
        ],
        [
            "title" => "Finish Date",
            "column" => "finish_date",
            "type" => "date",
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
            "label" => "Bill of Materials",
            "name" => "bom_name",
            "placeholder" => "Bill of Materials",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "select",
            "label" => "Manufacturing Status",
            "name" => "mfg_stat_name",
            "placeholder" => "Manufacturing Status",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "number",
            "label" => "Manufacturing Qty",
            "name" => "prod_manufacture_qty",
            "placeholder" => "Manufacturing Qty",
            "required" => true,
        ],
        [
            "type" => "date",
            "label" => "Start Date",
            "name" => "start_date",
            "placeholder" => "Start Date",
            "required" => true,
        ],
        [
            "type" => "date",
            "label" => "Finish Date",
            "name" => "finish_date",
            "placeholder" => "Finish Date",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "Status",
            "name" => "status",
            "placeholder" => "Status",
            "required" => true,
        ],
    ];

    protected $with = ['billOfMaterial','manufacturingStatus'];
}
