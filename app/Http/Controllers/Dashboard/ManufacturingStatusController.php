<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManufacturingStatusController extends ResourceController
{
    //
    protected $tableHeader = [
        [
            "title" => "Manufacturing Status",
            "column" => "mfg_stat_name",
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
            "label" => "Manufacturing Status",
            "name" => "mfg_stat_name",
            "placeholder" => "Manufacturing Status",
            "required" => true,
        ],
    ];
}
