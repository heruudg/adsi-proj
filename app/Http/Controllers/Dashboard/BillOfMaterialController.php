<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\BillOfMaterialItem;
use Illuminate\Http\Request;

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
            "title" => "BOM Quantity UOM",
            "column" => "bom_qty_uom",
        ],
        [
            "title" => "BOM Quantity",
            "column" => "bom_quantity",
        ],
        [
            "title" => "Product",
            "column" => "product.product_name",
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

    protected function prepareShowData(Request $request, $id)
    {
        $data = parent::prepareShowData($request, $id);
        $data['items'] = BillOfMaterialItem::where('bill_of_material_id', $id)->paginate();
        return $data;
    }

    protected function getFormChildren($id) {
        return [
            [
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
                "tableData" => BillOfMaterialItem::where('bill_of_material_id', $id)
                            ->with(['rawMaterial','workCenter'])
                            ->paginate(),
                "pageProperties" => [
                    "title" => "Bill of Material Items",
                    "resource" => "bill_of_material_items",
                    "pk" => "item_id",
                ],
            ]
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
