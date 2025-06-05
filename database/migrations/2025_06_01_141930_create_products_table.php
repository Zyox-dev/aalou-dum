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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('product_no', 6)->unique(); // 6-digit auto-generated code
            $table->string('name');
            $table->decimal('gold_qty', 10, 2)->nullable();
            $table->decimal('gold_rate', 10, 2)->nullable();
            $table->decimal('gold_total', 10, 2)->nullable();
            $table->string('gold_carat')->nullable();

            $table->decimal('diamond_qty', 10, 2)->nullable();
            $table->decimal('diamond_rate', 10, 2)->nullable();
            $table->decimal('diamond_total', 10, 2)->nullable();

            $table->decimal('color_stone_qty', 10, 2)->nullable();
            $table->decimal('color_stone_rate', 10, 2)->nullable();
            $table->decimal('color_stone_total', 10, 2)->nullable();

            $table->integer('labour_count')->nullable();
            $table->decimal('labour_rate', 10, 2)->nullable();
            $table->decimal('labour_total', 10, 2)->nullable();

            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('gross_amount', 10, 2)->nullable();
            $table->decimal('mrp', 10, 2)->nullable();

            $table->text('description')->nullable();
            $table->boolean('show_in_frontend')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
