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
        Schema::create('manufacturing_orders', function (Blueprint $table) {
            $table->id('mfg_order_id');
            $table->foreignId('bom_id')->constrained('bill_of_materials', 'bom_id');
            $table->foreignId('mfg_stat_id')->constrained('manufacturing_statuses', 'mfg_stat_id');
            $table->float('prod_manufacture_qty', 8, 2);
            $table->date('start_date');
            $table->date('finish_date');
            $table->string('status', 50);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturing_orders');
    }
};
