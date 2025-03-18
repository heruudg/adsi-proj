<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\BillOfMaterialItem;

class BillOfMaterialController extends ResourceController
{
    //
    protected $with = ['product'];
    protected $tableHeader = [
        [
            "title" => "BOM Name",
            "column" => "bom_name",
        ],
        [
            "title" => "BOM Quantity",
            "column" => "bom_quantity",
        ],
        [
            "title" => "BOM Quantity UOM",
            "column" => "bom_qty_uom",
        ],
        [
            "title" => "Product",
            "column" => "product.product_name",
        ],
    ];

    protected $formFields = [
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
            "type" => "select",
            "label" => "Product",
            "name" => "product_id",
            "placeholder" => "Product",
            "required" => true,
            "options" => [],
        ]
    ];

    protected function getFormFields(){
        $this->formFields[3]['options'] = $this->getProductOptions();

        return $this->formFields;
    }


    protected function getFormChildren($id) {
        $bomItemController = new BillOfMaterialItemController();
        return [
            $bomItemController->getPropAsChildren($id),
        ];
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
