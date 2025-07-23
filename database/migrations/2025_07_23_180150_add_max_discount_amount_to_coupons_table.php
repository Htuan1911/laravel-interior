<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('coupons', function (Blueprint $table) {
        $table->decimal('max_discount_amount', 10, 2)->nullable()->after('discount_percent');
    });
}

public function down()
{
    Schema::table('coupons', function (Blueprint $table) {
        $table->dropColumn('max_discount_amount');
    });
}
};
