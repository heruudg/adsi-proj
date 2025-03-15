<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterialItem;
use App\Models\RawMaterial;
use App\Models\WorkCenter;

class BillOfMaterialItemController extends ResourceController
{
    public function getPropAsChildren($bill_of_material_id){
        return             [
            "tableHeader" => [
                [
                    "title" => "Material",
                    "column" => "raw_material.material_name",
                ],
                [
                    "title" => "Work Center",
                    "column" => "work_center.work_ctr_name",
                ],
                [
                    "title" => "Quantity",
                    "column" => "bom_material_qty",
                ]
            ],
            "tableData" => BillOfMaterialItem::where('bill_of_material_id', $bill_of_material_id)
                        ->with(['rawMaterial','workCenter'])
                        ->paginate(),
            "pageProperties" => $this->getPageProperties(),
            "formFields" => [
                [
                    "type" => "select",
                    "label" => "Material",
                    "name" => "material_id",
                    "placeholder" => "Material",
                    "required" => true,
                    "options" => $this->getRawMaterialOptions(),
                ],
                [
                    "type" => "select",
                    "label" => "Work Center",
                    "name" => "work_center_id",
                    "placeholder" => "Work Center",
                    "required" => true,
                    "options" => $this->getWorkCenterOptions(),
                ],
                [
                    "type" => "number",
                    "label" => "Quantity",
                    "name" => "bom_material_qty",
                    "placeholder" => "Quantity",
                    "required" => true,
                ]
            ]
        ];

    }

    protected function getRawMaterialOptions()
    {
        return RawMaterial::all()->map(function($material) {
            return [
                'value' => $material->material_id,
                'label' => $material->material_name
            ];
        });
    }

    protected function getWorkCenterOptions()
    {
        return WorkCenter::all()->map(function($workCenter) {
            return [
                'value' => $workCenter->work_center_id,
                'label' => $workCenter->work_ctr_name
            ];
        });
    }
}
