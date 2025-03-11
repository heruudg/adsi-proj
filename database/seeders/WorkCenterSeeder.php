<?php

namespace Database\Seeders;

use App\Models\WorkCenter;
use Illuminate\Database\Seeder;

class WorkCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 sample work centers
        WorkCenter::factory()->count(10)->create();
    }
}