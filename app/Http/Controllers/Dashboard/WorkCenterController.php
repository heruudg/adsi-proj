<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkCenterController extends ResourceController
{
    //
    protected $tableHeader = [
        [
            "title" => "Work Center Name",
            "column" => "work_ctr_name",
        ],
        [
            "title" => "Work Center Description",
            "column" => "work_ctr_desc",
        ],
    ];

    protected $formFields = [
        [
            "type" => "text",
            "label" => "Work Center Name",
            "name" => "work_ctr_name",
            "placeholder" => "Work Center Name",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "Work Center Description",
            "name" => "work_ctr_desc",
            "placeholder" => "Work Center Description",
            "required" => true,
        ],
    ];
}
