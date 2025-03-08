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
}
