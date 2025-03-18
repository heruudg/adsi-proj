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
