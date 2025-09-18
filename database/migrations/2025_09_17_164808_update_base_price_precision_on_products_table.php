<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ⚠️ Cần package doctrine/dbal để dùng change()
            $table->decimal('base_price', 60, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Khôi phục lại về decimal(10,2) nếu rollback
            $table->decimal('base_price', 10, 2)->change();
        });
    }
};
