<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Mounting Upsize All
        $mountingUpsizeAll = Product::create([
            'name' => 'Mounting Upsize All',
            'category' => 'Mounting & Body',
            'image' => 'mounting-upsize-all.jpg',
            'description' => 'Universal mounting solution for various motorcycle types',
            'stock' => 3901,
            'sold' => 377,
            'ratings' => 192,
            'average_rating' => 4.6,
            'is_active' => true,
        ]);

        // Motor Type option for Mounting Upsize All
        $mountingUpsizeMotorOption = ProductOption::create([
            'product_id' => $mountingUpsizeAll->id,
            'option_name' => 'motor_type',
            'display_name' => 'Motor Type',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Motor Type values
        $motorTypes = [
            ['value' => 'aerox_old', 'display' => 'Aerox Old', 'available' => true],
            ['value' => 'aerox_new', 'display' => 'Aerox New', 'available' => true],
            ['value' => 'aerox_alpha', 'display' => 'Aerox Alpha', 'available' => true],
            ['value' => 'nmax_new', 'display' => 'Nmax New', 'available' => true],
            ['value' => 'nmax_neo', 'display' => 'Nmax Neo', 'available' => true],
            ['value' => 'lexy', 'display' => 'Lexy', 'available' => false], // unavailable
        ];

        foreach ($motorTypes as $index => $motorType) {
            ProductOptionValue::create([
                'product_option_id' => $mountingUpsizeMotorOption->id,
                'value' => $motorType['value'],
                'display_value' => $motorType['display'],
                'price_adjustment' => 0.00,
                'is_default' => $index === 0,
                'is_available' => $motorType['available'],
                'sort_order' => $index + 1,
            ]);
        }

        // Size option for Mounting Upsize All
        $mountingUpsizeSizeOption = ProductOption::create([
            'product_id' => $mountingUpsizeAll->id,
            'option_name' => 'size',
            'display_name' => 'Size',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Size values (3cm to 9cm)
        for ($size = 3; $size <= 9; $size++) {
            ProductOptionValue::create([
                'product_option_id' => $mountingUpsizeSizeOption->id,
                'value' => $size . 'cm',
                'display_value' => $size . 'cm',
                'price_adjustment' => 0.00,
                'is_default' => $size === 3,
                'is_available' => true,
                'sort_order' => $size - 2,
            ]);
        }

        // 2. Mounting Vario
        $mountingVario = Product::create([
            'name' => 'Mounting Vario',
            'category' => 'Mounting & Body',
            'image' => 'mounting-vario.jpg',
            'description' => 'Specialized mounting for Vario and compatible models',
            'stock' => 3006,
            'sold' => 3100, // 3.1K
            'ratings' => 1600, // 1.6K
            'average_rating' => 4.8,
            'is_active' => true,
        ]);

        // Motor Type option for Mounting Vario
        $mountingVarioMotorOption = ProductOption::create([
            'product_id' => $mountingVario->id,
            'option_name' => 'motor_type',
            'display_name' => 'Motor Type',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Motor Type values for Vario
        $varioMotorTypes = [
            ['value' => 'vario_led_old', 'display' => 'Vario LED Old'],
            ['value' => 'vario_led_new', 'display' => 'Vario LED New'],
            ['value' => 'beat_esp', 'display' => 'Beat ESP'],
            ['value' => 'scoopy_esp', 'display' => 'Scoopy ESP'],
        ];

        foreach ($varioMotorTypes as $index => $motorType) {
            ProductOptionValue::create([
                'product_option_id' => $mountingVarioMotorOption->id,
                'value' => $motorType['value'],
                'display_value' => $motorType['display'],
                'price_adjustment' => 0.00,
                'is_default' => $index === 0,
                'is_available' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // Size option for Mounting Vario
        $mountingVarioSizeOption = ProductOption::create([
            'product_id' => $mountingVario->id,
            'option_name' => 'size',
            'display_name' => 'Size',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Size values (3cm to 9cm) for Vario
        for ($size = 3; $size <= 9; $size++) {
            ProductOptionValue::create([
                'product_option_id' => $mountingVarioSizeOption->id,
                'value' => $size . 'cm',
                'display_value' => $size . 'cm',
                'price_adjustment' => 0.00,
                'is_default' => $size === 3,
                'is_available' => true,
                'sort_order' => $size - 2,
            ]);
        }

        // 3. Turbo SE Experience 60W
        $turboSE = Product::create([
            'name' => 'Turbo SE Experience 60W',
            'category' => 'Lampu',
            'image' => 'turbo-se-60w.jpg',
            'description' => 'High-performance 60W LED lamp with advanced features',
            'stock' => 90,
            'sold' => 0,
            'ratings' => 0,
            'average_rating' => 0.0,
            'is_active' => true,
        ]);

        // Quantity option for Turbo SE
        $turboSEQuantityOption = ProductOption::create([
            'product_id' => $turboSE->id,
            'option_name' => 'quantity',
            'display_name' => 'Quantity',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Quantity values
        $quantities = [
            ['value' => 'single', 'display' => 'Single', 'adjustment' => 0.00],
            ['value' => 'pair', 'display' => 'Pair', 'adjustment' => 20.00],
        ];

        foreach ($quantities as $index => $quantity) {
            ProductOptionValue::create([
                'product_option_id' => $turboSEQuantityOption->id,
                'value' => $quantity['value'],
                'display_value' => $quantity['display'],
                'price_adjustment' => $quantity['adjustment'],
                'is_default' => $index === 0,
                'is_available' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
