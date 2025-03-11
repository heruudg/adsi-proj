<?php

namespace Database\Seeders;

use App\Models\BillOfMaterial;
use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\WorkCenter;
use Illuminate\Database\Seeder;

class BillOfMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check for dependencies
        if (Product::count() === 0) {
            $this->command->error('No products found. Please seed products first.');
            return;
        }
        
        if (RawMaterial::count() === 0) {
            $this->command->error('No raw materials found. Please seed raw materials first.');
            return;
        }
        
        if (WorkCenter::count() === 0) {
            $this->command->error('No work centers found. Please seed work centers first.');
            return;
        }
        
        // Create multiple BOMs for each product
        $products = Product::all();
        
        foreach ($products as $product) {
            // Create 1-3 BOMs for each product
            $numBoms = random_int(1, 3);
            
            for ($i = 0; $i < $numBoms; $i++) {
                try {
                    BillOfMaterial::factory()->create([
                        'product_id' => $product->product_id,
                        'bom_name' => "BOM-{$product->product_name}-" . ($i + 1)
                    ]);
                } catch (\Exception $e) {
                    $this->command->error("Error creating BOM for product {$product->product_name}: {$e->getMessage()}");
                }
            }
        }
        
        $this->command->info('Bill of Materials seeded successfully: ' . BillOfMaterial::count() . ' records created.');
    }
}