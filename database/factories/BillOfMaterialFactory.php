<?php

namespace Database\Factories;

use App\Models\BillOfMaterial;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillOfMaterialFactory extends Factory
{
    protected $model = BillOfMaterial::class;

    public function definition(): array
    {
        // Common units of measure
        $uoms = ['kg', 'g', 'l', 'ml', 'pc', 'box', 'set', 'unit'];
        
        // Get product IDs from products table
        $productIds = Product::pluck('product_id')->toArray();
        if (empty($productIds)) {
            throw new \Exception('No products found. Please seed products first.');
        }
        
        // Get a random product
        $product = Product::find($this->faker->randomElement($productIds));
        
        // Generate BOM name based on product
        $bomName = "BOM-" . $product->product_name . "-" . substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        
        // Generate a realistic quantity
        $bomQuantity = $this->faker->randomFloat(2, 1, 100);
        
        return [
            'product_id' => $product->product_id,
            'bom_name' => $bomName,
            'bom_quantity' => $bomQuantity,
            'bom_qty_uom' => $product->product_uom ?? $this->faker->randomElement($uoms),
        ];
    }
}