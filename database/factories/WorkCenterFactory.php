<?php

namespace Database\Factories;

use App\Models\WorkCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkCenterFactory extends Factory
{
    protected $model = WorkCenter::class;

    public function definition(): array
    {
        $workCenterTypes = [
            'Assembly Line',
            'Packaging Station',
            'Quality Control',
            'Material Processing',
            'Machine Shop',
            'Welding Station',
            'Paint Booth',
            'Inspection Area',
            'Fabrication Cell',
            'Testing Lab'
        ];
        
        $areaNumbers = [
            'A1', 'A2', 'B1', 'B2', 'C1', 
            'North', 'South', 'East', 'West', 'Central'
        ];
        
        return [
            'work_ctr_name' => $this->faker->randomElement($workCenterTypes) . ' ' . $this->faker->randomElement($areaNumbers),
            'work_ctr_desc' => $this->faker->sentence(mt_rand(1, 4)),
        ];
    }
}