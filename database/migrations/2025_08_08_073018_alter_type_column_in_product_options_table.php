<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        // Chuyển type từ ENUM sang SET
        DB::statement("ALTER TABLE product_options MODIFY COLUMN type SET('color', 'size', 'material', 'group') NOT NULL");
    }

    public function down()
    {
        // Quay lại ENUM ban đầu nếu rollback
        DB::statement("ALTER TABLE product_options MODIFY COLUMN type ENUM('color', 'size', 'material') NOT NULL");
    }
};
