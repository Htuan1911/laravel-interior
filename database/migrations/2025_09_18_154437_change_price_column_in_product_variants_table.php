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
        Schema::table('product_variants', function (Blueprint $table) {
            // Đổi kiểu cột price thành decimal(30, 2)
            $table->decimal('price', 30, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Quay lại kiểu cột decimal(10, 2)
            $table->decimal('price', 10, 2)->change();
        });
    }
};
