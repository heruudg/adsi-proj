<?php

namespace Database\Factories;

use App\Models\BillOfMaterial;
use App\Models\BillOfMaterialItem;
use App\Models\RawMaterial;
use App\Models\WorkCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillOfMaterialItemFactory extends Factory
{
    protected $model = BillOfMaterialItem::class;

    public function definition(): array
    {
        // Get IDs from related tables
        $bomIds = BillOfMaterial::pluck('bom_id')->toArray();
        $materialIds = RawMaterial::pluck('material_id')->toArray();
        $workCenterIds = WorkCenter::pluck('work_center_id')->toArray();
        
        // Check if we have the necessary data
        if (empty($bomIds)) {
            throw new \Exception('No bill of materials found. Please seed bill of materials first.');
        }
        
        if (empty($materialIds)) {
            throw new \Exception('No raw materials found. Please seed raw materials first.');
        }
        
        if (empty($workCenterIds)) {
            throw new \Exception('No work centers found. Please seed work centers first.');
        }
        
        return [
            'material_id' => $this->faker->randomElement($materialIds),
            'work_ctr_id' => $this->faker->randomElement($workCenterIds),
            'bill_of_material_id' => $this->faker->randomElement($bomIds),
            'bom_material_qty' => $this->faker->randomFloat(2, 0.1, 100),
        ];
    }
}