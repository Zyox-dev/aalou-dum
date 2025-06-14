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
        Schema::table('products', function (Blueprint $table) {
            $table->uuid('gold_labour_id')->nullable()->after('gold_carat');
            $table->uuid('diamond_labour_id')->nullable()->after('gold_labour_id');
            $table->uuid('color_stone_labour_id')->nullable()->after('diamond_labour_id');

            $table->foreign('gold_labour_id')->references('id')->on('labours')->nullOnDelete();
            $table->foreign('diamond_labour_id')->references('id')->on('labours')->nullOnDelete();
            $table->foreign('color_stone_labour_id')->references('id')->on('labours')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['gold_labour_id']);
            $table->dropForeign(['diamond_labour_id']);
            $table->dropForeign(['color_stone_labour_id']);

            $table->dropColumn(['gold_labour_id', 'diamond_labour_id', 'color_stone_labour_id']);
        });
    }
};
