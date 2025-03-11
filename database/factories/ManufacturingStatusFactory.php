<?php

namespace Database\Factories;

use App\Models\ManufacturingStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturingStatusFactory extends Factory
{
    protected $model = ManufacturingStatus::class;

    public function definition(): array
    {
        $statuses = [
            'Planned',
            'In Progress',
            'Quality Check',
            'Completed',
            'On Hold',
            'Cancelled',
            'Failed'
        ];
        
        return [
            'mfg_stat_name' => $this->faker->unique()->randomElement($statuses),
        ];
    }
}