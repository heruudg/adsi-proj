<?php

namespace Database\Factories;

use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class RawMaterialFactory extends Factory
{
    protected $model = RawMaterial::class;

    public function definition(): array
    {
        // Common units of measure for raw materials
        $uoms = ['kg', 'g', 'l', 'ml', 'pc', 'ton', 'box', 'sheet'];
        
        // Get inventory location IDs from the database
        $inventoryLocationIds = DB::table('inventory_locations')->pluck('invt_loc_id')->toArray();
        if (empty($inventoryLocationIds)) {
            $inventoryLocationIds = [1, 2, 3]; // Fallback IDs
        }

        // Common raw material names for more realistic data
        $materialNames = [
            'Wood', 'Steel', 'Cotton', 'Aluminum', 'Glass', 'Plastic', 'Rubber',
            'Copper', 'Clay', 'Cement', 'Leather', 'Fabric', 'Paper', 'Sand',
            'Silicon', 'Flour', 'Sugar', 'Salt', 'Oil', 'Milk', 'Eggs'
        ];
        
        $materialName = $this->faker->randomElement($materialNames) . ' ' . 
                        $this->faker->word() . ' ' . 
                        $this->faker->randomElement(['Grade A', 'Grade B', 'Premium', 'Standard', 'Type 1', 'Type 2']);

        return [
            'invt_loc_name' => $this->faker->randomElement($inventoryLocationIds),
            'material_name' => $materialName,
            'material_quantity' => $this->faker->randomFloat(2, 10, 5000),
            'material_uom' => $this->faker->randomElement($uoms),
        ];
    }
}