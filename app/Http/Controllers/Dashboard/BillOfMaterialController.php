<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillOfMaterialController extends ResourceController
{
    //
    protected $with = ['product','rawMaterial','workCenter'];
    protected $tableHeader = [
        [
            "title" => "BOM Name",
            "column" => "bom_name",
        ],
        [
            "title" => "BOM Quantity UOM",
            "column" => "bom_qty_uom",
        ],
        [
            "title" => "BOM Quantity",
            "column" => "bom_quantity",
        ],
        [
            "title" => "Material UOM",
            "column" => "material_uom",
        ],
        [
            "title" => "Material Name",
            "column" => "material_name",
        ],
        [
            "title" => "Product",
            "column" => "product.product_name",
        ],
        [
            "title" => "Raw Material",
            "column" => "raw_material.material_name",
        ],
        [
            "title" => "Work Center",
            "column" => "work_center.work_ctr_name",
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
            "label" => "Product",
            "name" => "product_id",
            "placeholder" => "Product",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "select",
            "label" => "Raw Material",
            "name" => "material_id",
            "placeholder" => "Raw Material",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "select",
            "label" => "Work Center",
            "name" => "work_ctr_id",
            "placeholder" => "Work Center",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "text",
            "label" => "BOM Name",
            "name" => "bom_name",
            "placeholder" => "BOM Name",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "BOM Quantity UOM",
            "name" => "bom_qty_uom",
            "placeholder" => "BOM Quantity UOM",
            "required" => true,
        ],
        [
            "type" => "number",
            "label" => "BOM Quantity",
            "name" => "bom_quantity",
            "placeholder" => "BOM Quantity",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "Material UOM",
            "name" => "material_uom",
            "placeholder" => "Material UOM",
            "required" => true,
        ],
        [
            "type" => "text",
            "label" => "Material Name",
            "name" => "material_name",
            "placeholder" => "Material Name",
            "required" => true,
        ],
    ];

    protected function getFormFields(){
        $this->formFields[0]['options'] = $this->getProductOptions();
        $this->formFields[1]['options'] = $this->getRawMaterialOptions();
        $this->formFields[2]['options'] = $this->getWorkCenterOptions();
        return $this->formFields;
    }
    
    protected function getProductOptions()
    {
        return \App\Models\Product::all()->map(function($product) {
            return [
                'value' => $product->product_id,
                'label' => $product->product_name
            ];
        });
    }
    
    protected function getRawMaterialOptions()
    {
        return \App\Models\RawMaterial::all()->map(function($material) {
            return [
                'value' => $material->material_id,
                'label' => $material->material_name
            ];
        });
    }
    
    protected function getWorkCenterOptions()
    {
        return \App\Models\WorkCenter::all()->map(function($workCenter) {
            return [
                'value' => $workCenter->work_center_id,
                'label' => $workCenter->work_ctr_name
            ];
        });
    }
}
