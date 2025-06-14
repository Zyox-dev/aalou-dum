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
        Schema::create('approval_serial_trackers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->tinyInteger('approval_type');
            $table->string('year_month', 7);
            $table->integer('last_number')->default(0);
            $table->timestamps();

            $table->unique(['approval_type', 'year_month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_serial_trackers');
    }
};
