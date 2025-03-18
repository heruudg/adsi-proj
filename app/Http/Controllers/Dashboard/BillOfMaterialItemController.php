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
        return [
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
                    "name" => "work_ctr_id",
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
            ],
            "reference" => [
                "value" => $bill_of_material_id,
                "objName" => "bill_of_material",
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

    public function storeBomItem(Request $request, $bom_id)
    {
        $data = json_decode($request->getContent(), true);

        
        $bomItem = new BillOfMaterialItem();
        $bomItem->bill_of_material_id = $bom_id;
        $bomItem->material_id = $data['material_id'];
        $bomItem->work_ctr_id = $data['work_ctr_id'];
        $bomItem->bom_material_qty = $data['bom_material_qty'];
        $bomItem->save();
        // echo $bom_id;'
        return redirect()->back()->with('message', 'Bill of Material item added successfully');
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
