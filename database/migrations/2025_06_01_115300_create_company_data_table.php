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
        Schema::create('company_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('company_name');
            $table->text('address');
            $table->string('gstin')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('admin_cost_percent', 5, 2)->default(0);
            $table->decimal('margin_percent', 5, 2)->default(0);
            $table->text('carats')->nullable(); // comma-separated: "18K,20K,22K,24K"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_data');
    }
};
