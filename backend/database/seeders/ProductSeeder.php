<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\ProductVariation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Simple product (no variation)
        |--------------------------------------------------------------------------
        */
        Product::factory(3)->create()->each(function ($product) {
            ProductDetails::factory()->create([
                'product_id' => $product->id,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Color-only product
        |--------------------------------------------------------------------------
        */
        $prod = Product::factory()->create();

        ProductDetails::factory()->create([
            'product_id' => $prod->id,
        ]);

        foreach (['Red', 'Blue', 'Black'] as $color) {
            ProductVariation::create([
                'product_id' => $prod->id,
                'color' => $color,
                'size' => null,
                'sku' => strtoupper(Str::random(10)),
                'price' => $prod->price,
                'stock' => rand(5, 30),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Size-only product
        |--------------------------------------------------------------------------
        */
        $prod2 = Product::factory()->create();

        ProductDetails::factory()->create([
            'product_id' => $prod2->id,
        ]);

        foreach (['S', 'M', 'L'] as $size) {
            ProductVariation::create([
                'product_id' => $prod2->id,
                'color' => null,
                'size' => $size,
                'sku' => strtoupper(Str::random(10)),
                'price' => $prod2->price,
                'stock' => rand(5, 30),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Color + Size product
        |--------------------------------------------------------------------------
        */
        $prod3 = Product::factory()->create();

        ProductDetails::factory()->create([
            'product_id' => $prod3->id,
        ]);

        foreach (['Red', 'Blue'] as $color) {
            foreach (['M', 'L'] as $size) {
                ProductVariation::create([
                    'product_id' => $prod3->id,
                    'color' => $color,
                    'size' => $size,
                    'sku' => strtoupper(Str::random(10)),
                    'price' => $prod3->price,
                    'stock' => rand(0, 25),
                ]);
            }
        }
    }
}