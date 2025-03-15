<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BillOfMaterial;
use App\Models\BillOfMaterialItem;
use App\Models\RawMaterial;
use App\Models\WorkCenter;

class BillOfMaterialItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we have the necessary data first
        $bomCount = BillOfMaterial::count();
        $materialCount = RawMaterial::count();
        $workCenterCount = WorkCenter::count();
        
        if ($bomCount === 0) {
            $this->command->warn('No bill of materials found. Please run BillOfMaterialSeeder first.');
            return;
        }
        
        if ($materialCount === 0) {
            $this->command->warn('No raw materials found. Please run RawMaterialSeeder first.');
            return;
        }
        
        if ($workCenterCount === 0) {
            $this->command->warn('No work centers found. Please run WorkCenterSeeder first.');
            return;
        }
        
        $this->command->info('Creating BOM Items...');
        
        // Get all BOMs
        $boms = BillOfMaterial::all();
        
        // For each BOM, create 3-8 BOM items
        foreach ($boms as $bom) {
            $itemCount = rand(3, 8);
            $this->command->info("Creating {$itemCount} items for BOM: {$bom->bom_name}");
            
            // Get random materials that haven't been used for this BOM yet
            $usedMaterialIds = [];
            
            for ($i = 0; $i < $itemCount; $i++) {
                // Get available material IDs that haven't been used for this BOM
                $availableMaterials = RawMaterial::whereNotIn('material_id', $usedMaterialIds)
                    ->pluck('material_id')
                    ->toArray();
                
                if (empty($availableMaterials)) {
                    $this->command->warn('Ran out of unique materials for this BOM');
                    break;
                }
                
                // Get a random material ID
                $materialId = $availableMaterials[array_rand($availableMaterials)];
                $usedMaterialIds[] = $materialId;
                
                // Get a random work center
                $workCenter = WorkCenter::inRandomOrder()->first();
                
                if (!$workCenter) {
                    $this->command->warn('No work centers available');
                    continue;
                }
                
                // Create BOM item using factory
                BillOfMaterialItem::factory()->create([
                    'bill_of_material_id' => $bom->bom_id,
                    'material_id' => $materialId,
                    'work_ctr_id' => $workCenter->work_center_id,
                    'bom_material_qty' => rand(1, 100) / 10, // Generate decimal between 0.1 and 10.0
                ]);
            }
        }
        
        $totalItemsCreated = BillOfMaterialItem::count();
        $this->command->info("BOM Items created successfully! Total items: {$totalItemsCreated}");
    }
}