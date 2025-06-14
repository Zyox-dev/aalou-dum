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
        Schema::create('material_ledgers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date'); // 🔥 For filtering and report
            $table->tinyInteger('material_type');
            $table->tinyInteger('entry_type');
            $table->decimal('quantity', 10, 3);
            $table->uuid('labour_id')->nullable()->index();
            $table->uuid('reference_id');
            $table->string('reference_type');
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('labour_id')->references('id')->on('labours')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_ledgers');
    }
};
