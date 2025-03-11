<?php

namespace Database\Factories;

use App\Models\ManufacturingOrder;
use App\Models\ManufacturingStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ManufacturingOrderFactory extends Factory
{
    protected $model = ManufacturingOrder::class;

    public function definition(): array
    {
        // Get BOM IDs from database
        $bomIds = DB::table('bill_of_materials')->pluck('bom_id')->toArray();
        if (empty($bomIds)) $bomIds = [1, 2, 3]; // Fallback
        
        // Get manufacturing status IDs
        $mfgStatIds = DB::table('manufacturing_statuses')->pluck('mfg_stat_id')->toArray();
        if (empty($mfgStatIds)) $mfgStatIds = [1, 2, 3, 4]; // Fallback
        
        // Generate start date between 3 months ago and now
        $startDate = $this->faker->dateTimeBetween('-3 months', '+1 month')->format('Y-m-d');
        
        // Generate finish date between start date and 2 months after
        $finishDate = $this->faker->dateTimeBetween($startDate, date('Y-m-d', strtotime($startDate . ' +60 days')))->format('Y-m-d');
        
        // Status options (note: this is different from mfg_stat_id)
        $statusOptions = [
            'On Schedule', 
            'Delayed', 
            'Ahead of Schedule', 
            'On Hold',
            'Quality Issue',
            'Material Shortage'
        ];
        
        return [
            'bom_id' => $this->faker->randomElement($bomIds),
            'mfg_stat_id' => $this->faker->randomElement($mfgStatIds),
            'prod_manufacture_qty' => $this->faker->randomFloat(2, 10, 1000),
            'start_date' => $startDate,
            'finish_date' => $finishDate,
            'status' => $this->faker->randomElement($statusOptions),
        ];
    }
}