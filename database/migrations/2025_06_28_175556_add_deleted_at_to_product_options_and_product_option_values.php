<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up(): void
    {
        Schema::table('product_options', function (Blueprint $table) {
            if (!Schema::hasColumn('product_options', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable()->after('updated_at');
            }
        });

        Schema::table('product_option_values', function (Blueprint $table) {
            if (!Schema::hasColumn('product_option_values', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable()->after('updated_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_options', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('product_option_values', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};
