<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoutingController extends ResourceController
{
    protected $tableHeader = [
        [
            "title" => "ID",
            "column" => "id",
        ],
        [
            "title" => "Name",
            "column" => "name",
        ],
        [
            "title" => "Code",
            "column" => "code",
        ],
        [
            "title" => "Created At",
            "column" => "created_at",
        ],
        [
            "title" => "Updated At",
            "column" => "updated_at",
        ]
    ];

    protected $formFields = [
        [
            "type" => "text",
            "label" => "Name",
            "name" => "name",
            "placeholder" => "Name",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "Code",
            "name" => "code",
            "placeholder" => "Code",
            "required" => true,
        ],
    ];
    
}
