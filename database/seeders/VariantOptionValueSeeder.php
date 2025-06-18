<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantOptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = DB::table('products')->latest('id')->first();
        if (!$product) {
            $this->command->error('No product found! Run ProductSeeder first.');
            return;
        }

        $variants = DB::table('product_variants')->where('product_id', $product->id)->get();
        $optionValues = DB::table('product_option_values')
            ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
            ->where('product_options.product_id', $product->id)
            ->select('product_option_values.*', 'product_options.name as option_name')
            ->get();

        $blackOptionValue = $optionValues->firstWhere('value', 'Black');
        $whiteOptionValue = $optionValues->firstWhere('value', 'White');
        $gb64OptionValue = $optionValues->firstWhere('value', '64GB');
        $gb128OptionValue = $optionValues->firstWhere('value', '128GB');

        $black64Variant = $variants->firstWhere('sku', 'SM-BLK-64');
        $white128Variant = $variants->firstWhere('sku', 'SM-WHT-128');

        if (!$blackOptionValue || !$whiteOptionValue || !$gb64OptionValue || !$gb128OptionValue || !$black64Variant || !$white128Variant) {
            $this->command->error('Missing variants or option values! Run previous seeders first.');
            return;
        }

        DB::table('variant_option_values')->insert([
            // Variant Black-64GB
            [
                'variant_id' => $black64Variant->id,
                'product_option_value_id' => $blackOptionValue->id,
            ],
            [
                'variant_id' => $black64Variant->id,
                'product_option_value_id' => $gb64OptionValue->id,
            ],
            // Variant White-128GB
            [
                'variant_id' => $white128Variant->id,
                'product_option_value_id' => $whiteOptionValue->id,
            ],
            [
                'variant_id' => $white128Variant->id,
                'product_option_value_id' => $gb128OptionValue->id,
            ],
        ]);
    }
}
