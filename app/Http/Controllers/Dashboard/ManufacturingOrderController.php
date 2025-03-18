<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterial;
use App\Models\ManufacturingStatus;

class ManufacturingOrderController extends ResourceController
{
    //
    protected $tableHeader = [
        [
            "title" => "Bill of Materials",
            "column" => "bill_of_material.bom_name",
        ],
        [
            "title" => "Manufacturing Status",
            "column" => "manufacturing_status.mfg_stat_name",
        ],
        [
            "title" => "Manufacturing Qty",
            "column" => "prod_manufacture_qty",
        ],
        [
            "title" => "Start Date",
            "column" => "start_date",
            "type" => "date",
        ],
        [
            "title" => "Finish Date",
            "column" => "finish_date",
            "type" => "date",
        ],
    ];

    protected $formFields = [
        [
            "type" => "select",
            "label" => "Bill of Materials",
            "name" => "bom_id",
            "placeholder" => "Bill of Materials",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "select",
            "label" => "Manufacturing Status",
            "name" => "mfg_stat_id",
            "placeholder" => "Manufacturing Status",
            "required" => true,
            "options" => [],
        ],
        [
            "type" => "number",
            "label" => "Manufacturing Qty",
            "name" => "prod_manufacture_qty",
            "placeholder" => "Manufacturing Qty",
            "required" => true,
        ],
        [
            "readOnly" => true,
            "label" => "Start Date",
            "name" => "start_date",
            "placeholder" => "Start Date",
            "required" => true,
        ],
        [
            "readOnly" => true,
            "label" => "Finish Date",
            "name" => "finish_date",
            "placeholder" => "Finish Date",
            "required" => true,
        ],
    ];

    protected function getFormFields(){
        $this->formFields[0]['options'] = $this->getBillOfMaterialOptions();
        $this->formFields[1]['options'] = $this->getManufacturingStatusOptions();
        return $this->formFields;
    }

    protected function getBillOfMaterialOptions()
    {
        return BillOfMaterial::all()->map(function($bom) {
            return [
                'value' => $bom->bom_id,
                'label' => $bom->bom_name
            ];
        });
    }

    public function getManufacturingStatusOptions()
    {
        return ManufacturingStatus::all()->map(function($status) {
            return [
                'value' => $status->mfg_stat_id,
                'label' => $status->mfg_stat_name
            ];
        });
    }

    protected function getFormButtons($data){
        $buttons = [];
        if($data){
            if($data['start_date'] == null){
                $buttons[] = [
                    'label' => 'Start Manufacturing',
                    'icon' => 'play',
                    'variant' => 'outline',
                    'action' => 'api',
                    'method' => 'POST',
                    'data' => $data,
                    'url' => "/manufacturing_order/{$data['mfg_order_id']}/start",
                ];
            }
            if($data['start_date'] != null && $data['finish_date'] == null){
                $buttons[] = [
                    'label' => 'Stop Manufacturing',
                    'icon' => 'stop',
                    'variant' => 'outline',
                    'action' => 'api',
                    'method' => 'POST',
                    'data' => $data,
                    'url' => "/manufacturing_order/{$data['mfg_order_id']}/stop",
                ];

            }
        }
        return $buttons;
    }

    public function startManufacturing($mfg_id){
        $data = $this->model::findOrFail($mfg_id);
        $data->start_date = now();
        $data->mfg_stat_id = 2;
        $data->save();
        $this->updateQty($data);
        return redirect()->back()->with('message', 'Manufacturing started successfully');
    }

    private function updateQty($manufacturingOrder){
        $bomItems = $manufacturingOrder->billOfMaterial->billOfMaterialItems;
        foreach($bomItems as $bomItem){
            $bomItem->rawMaterial->material_qty -= $bomItem->bom_material_qty * $manufacturingOrder->prod_manufacture_qty;
            $bomItem->rawMaterial->save();
        }
    }


    public function stopManufacturing($mfg_id){
        $data = $this->model::findOrFail($mfg_id);
        $data->finish_date = now();
        $data->mfg_stat_id = 4;
        $data->save();

        return redirect()->back()->with('message', 'Manufacturing stopped successfully');
    }

    private function updateQtyProduct($manufacturingOrder){
        $product = $manufacturingOrder->billOfMaterial->product;
        $product->product_qty += $manufacturingOrder->prod_manufacture_qty;
        $product->save();
    }

    protected $with = ['billOfMaterial','manufacturingStatus'];
}
