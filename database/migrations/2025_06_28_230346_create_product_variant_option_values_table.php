<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantOptionValuesTable extends Migration
{
    public function up()
    {
        Schema::create('product_variant_option_values', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_variant_id');
            $table->unsignedBigInteger('product_option_id');
            $table->unsignedBigInteger('product_option_value_id');

            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('product_option_id')->references('id')->on('product_options')->onDelete('cascade');
            $table->foreign('product_option_value_id')->references('id')->on('product_option_values')->onDelete('cascade');

            // Mỗi biến thể chỉ nên có 1 giá trị cho mỗi option
            $table->unique(['product_variant_id', 'product_option_id'], 'variant_option_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variant_option_values');
    }
}

