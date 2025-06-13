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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_name', 100);
            $table->string('customer_address')->nullable();
            $table->string('customer_gstin', 20)->nullable();
            $table->string('customer_pan', 20)->nullable();
            $table->date('purchase_date');

            $table->decimal('cgst_percent', 5, 2)->default(0);
            $table->decimal('sgst_percent', 5, 2)->default(0);
            $table->decimal('igst_percent', 5, 2)->default(0);

            $table->decimal('subtotal_amount', 10, 2)->default(0);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);

            $table->timestamps();
        });

        // invoice_items table
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invoice_id');
            $table->uuid('product_id');

            $table->string('product_code', 6);
            $table->string('product_name');
            $table->decimal('quantity', 10, 2);
            $table->decimal('rate', 10, 2); // from product.mrp
            $table->decimal('total', 10, 2); // rate * quantity

            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
