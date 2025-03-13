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
        Schema::create('bill_of_materials', function (Blueprint $table) {
            $table->id('bom_id');
            $table->foreignId('material_id')->constrained('raw_materials', 'material_id');
            $table->foreignId('work_ctr_id')->constrained('work_centers', 'work_center_id');
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->float('bom_quantity', 8, 2);
            $table->float('bom_material_qty', 8, 2);
            $table->string('bom_name', 50);
            $table->string('bom_qty_uom', 10);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_of_materials');
    }
};
