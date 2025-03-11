<?php

namespace Database\Seeders;

use App\Models\ManufacturingStatus;
use Illuminate\Database\Seeder;

class ManufacturingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define standard manufacturing statuses
        $statuses = [
            'Planned',
            'In Progress',
            'Quality Check',
            'Completed',
            'On Hold',
            'Cancelled',
            'Failed'
        ];
        
        foreach ($statuses as $status) {
            ManufacturingStatus::create([
                'mfg_stat_name' => $status,
            ]);
        }
    }
}