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
        Schema::create('purchases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->tinyInteger('purchase_type');
            $table->decimal('rate_per_unit', 10, 2);
            $table->decimal('karrot', 8, 2);
            $table->decimal('weight_in_gram', 10, 2)->nullable(); // Only for Gold
            $table->decimal('amount_total', 12, 2);
            $table->decimal('gst_percent', 5, 2)->nullable();     // Only for Gold
            $table->date('purchase_date');
            $table->string('color_stone_name')->nullable();       // Only for Color Stone
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
