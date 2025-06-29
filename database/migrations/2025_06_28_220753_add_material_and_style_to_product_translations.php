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
    Schema::table('product_translations', function (Blueprint $table) {
        $table->string('material')->nullable()->after('name');
        $table->string('style')->nullable()->after('material');
    });
}

public function down(): void
{
    Schema::table('product_translations', function (Blueprint $table) {
        $table->dropColumn(['material', 'style']);
    });
}

};
