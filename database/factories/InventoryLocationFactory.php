<?php

namespace Database\Factories;

use App\Models\InventoryLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryLocationFactory extends Factory
{
    protected $model = InventoryLocation::class;

    public function definition(): array
    {
        return [
            'invt_loc_name' => $this->faker->unique()->words(2, true)
            // Add other fields your inventory_locations table has
        ];
    }
}