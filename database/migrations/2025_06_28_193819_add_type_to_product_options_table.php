<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('product_options', function (Blueprint $table) {
        $table->enum('type', ['color', 'material', 'size', 'other'])->default('other')->after('name');
    });
}

public function down(): void
{
    Schema::table('product_options', function (Blueprint $table) {
        $table->dropColumn('type');
    });
}

};
