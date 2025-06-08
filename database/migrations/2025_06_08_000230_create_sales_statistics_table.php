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
        Schema::create('sales_statistics', function (Blueprint $table) {
            $table->id();
            $table->enum('period_type', ['daily', 'monthly', 'yearly']);
            $table->date('period_start');
            $table->date('period_end');
            $table->integer('total_orders');
            $table->decimal('total_revenue', 15, 2);
            $table->integer('total_products_sold');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_statistics');
    }
};
