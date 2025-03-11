<?php

namespace Database\Seeders;

use App\Models\ManufacturingOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we have the required related data
        $bomsExist = DB::table('bill_of_materials')->count() > 0;
        $statusesExist = DB::table('manufacturing_statuses')->count() > 0;
        
        if (!$bomsExist || !$statusesExist) {
            $this->command->info('Manufacturing Order seeding skipped: Missing required related data (BOMs or Manufacturing Statuses)');
            return;
        }
        
        // Create 25 sample manufacturing orders
        ManufacturingOrder::factory()->count(25)->create();
        
        $this->command->info('Manufacturing Orders seeded successfully');
    }
}