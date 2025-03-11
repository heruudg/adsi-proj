<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Common units of measure for products
        $uoms = ['kg', 'g', 'l', 'ml', 'pc', 'box', 'set', 'unit'];
        
        // Get inventory location IDs from the database or use fallback
        $inventoryLocationIds = DB::table('inventory_locations')->pluck('invt_loc_id')->toArray();
        if (empty($inventoryLocationIds)) {
            $inventoryLocationIds = [1, 2, 3]; // Fallback IDs
        }

        return [
            'invt_loc_name' => $this->faker->randomElement($inventoryLocationIds),
            'product_name' => $this->faker->words(mt_rand(1, 3), true),
            'product_quantity' => $this->faker->randomFloat(2, 1, 1000),
            'product_uom' => $this->faker->randomElement($uoms),
        ];
    }
}