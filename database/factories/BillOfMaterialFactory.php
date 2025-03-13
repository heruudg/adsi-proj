<?php

namespace Database\Factories;

use App\Models\BillOfMaterial;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\WorkCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillOfMaterialFactory extends Factory
{
    protected $model = BillOfMaterial::class;

    public function definition(): array
    {
        // Common units of measure
        $uoms = ['kg', 'g', 'l', 'ml', 'pc', 'box', 'set', 'unit'];
        
        // Get IDs from related tables
        $productIds = Product::pluck('product_id')->toArray();
        if (empty($productIds)) {
            throw new \Exception('No products found. Please seed products first.');
        }
        
        $materialIds = RawMaterial::pluck('material_id')->toArray();
        if (empty($materialIds)) {
            throw new \Exception('No raw materials found. Please seed raw materials first.');
        }
        
        $workCenterIds = WorkCenter::pluck('work_center_id')->toArray();
        if (empty($workCenterIds)) {
            throw new \Exception('No work centers found. Please seed work centers first.');
        }
        
        // Get a random product, material and work center
        $product = Product::find($this->faker->randomElement($productIds));
        $material = RawMaterial::find($this->faker->randomElement($materialIds));
        $workCenter = WorkCenter::find($this->faker->randomElement($workCenterIds));
        
        // Set up the BOM name
        $bomName = "BOM-" . $product->product_name . "-" . substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        
        // Generate a realistic quantity
        $bomQuantity = $this->faker->randomFloat(2, 1, 100);
        $bomMaterialQty = $this->faker->randomFloat(2, 0.1, 10) * $bomQuantity;
        
        return [
            'material_id' => $material->material_id,
            'work_ctr_id' => $workCenter->work_center_id,
            'product_id' => $product->product_id,
            'bom_quantity' => $bomQuantity,
            'bom_material_qty' => $bomMaterialQty,
            'bom_name' => $bomName,
            'bom_qty_uom' => $product->product_uom ?? $this->faker->randomElement($uoms),
        ];
    }
}