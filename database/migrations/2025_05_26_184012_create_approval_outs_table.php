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
        Schema::create('approval_outs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('serial_no')->unique(); // auto-generated
            $table->tinyInteger('approval_type');
            $table->date('date');
            $table->decimal('rate', 10, 2);
            $table->decimal('qty', 10, 2); // grams or karrots
            $table->decimal('gst_percent', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_outs');
    }
};
