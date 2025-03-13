<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends ResourceController
{
    //
    protected $with = ['roles'];

    protected $tableHeader = [
        [
            "title" => "Name",
            "column" => "name",
        ],
        [
            "title" => "Email",
            "column" => "email",
        ],
        [
            "title" => "Role",
            "column" => "roles.0.name",
        ],
        [
            "title" => "Created At",
            "column" => "created_at",
            "type" => "datetime"
        ],
        [
            "title" => "Updated At",
            "column" => "updated_at",
            "type" => "datetime"
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
            "type" => "email",
            "label" => "Email",
            "name" => "email",
            "placeholder" => "Email",
            "required" => true,
        ],
        [
            "type" => "select",
            "label" => "Role",
            "name" => "role_id",
            "placeholder" => "Role",
            "options" => [],
            "required" => true,
        ],
    ];

    protected function getRoles(){
        return \Spatie\Permission\Models\Role::all()->map(function($role){
            return [
                "label" => $role->name,
                "value" => $role->id
            ];
        });
    }


    protected function prepareShowData(Request $request, $id)
    {
        $data = parent::prepareShowData($request, $id);
        $data['role_id'] = $data['roles'][0]->id;
        return $data;
    }

    protected function getFormFields(){
        $this->formFields[2]['options'] = $this->getRoles();
        return $this->formFields;
    }
}
