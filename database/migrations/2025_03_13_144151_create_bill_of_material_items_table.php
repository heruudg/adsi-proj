<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bill_of_material_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('raw_materials', 'material_id');
            $table->foreignId('work_ctr_id')->constrained('work_centers', 'work_center_id');
            $table->foreignId('bill_of_material_id')->constrained('bill_of_materials', 'bom_id');
            $table->float('bom_material_qty', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_of_material_items');
    }
};
