<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\ProductVariation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create()->each(function($p){
        ProductDetails::factory()->create(['product_id' => $p->id]);
    });

    // Color-only product
    $prod = Product::factory()->create();
    ProductDetails::factory()->create([
        'product_id' => $prod->id,
        'color' => 'Red,Blue,Black',
        'size' => null
    ]);
    foreach(['Red','Blue','Black'] as $c){
        ProductVariation::create([
            'product_id' => $prod->id,
            'color' => $c,
            'size' => null,
            'sku' => strtoupper(Str::random(8)),
            'price' => $prod->price,
            'stock' => rand(5,30)
        ]);
    }

    // Size-only product
    $prod2 = Product::factory()->create();
    ProductDetails::factory()->create([
        'product_id' => $prod2->id,
        'color' => null,
        'size' => 'S,M,L'
    ]);
    foreach(['S','M','L'] as $s){
        ProductVariation::create([
            'product_id' => $prod2->id,
            'color' => null,
            'size' => $s,
            'sku' => strtoupper(Str::random(8)),
            'price' => $prod2->price,
            'stock' => rand(5,30)
        ]);
    }

    // Color + Size product
    $prod3 = Product::factory()->create();
    ProductDetails::factory()->create([
        'product_id' => $prod3->id,
        'color' => 'Red,Blue',
        'size' => 'M,L'
    ]);
    foreach(['Red','Blue'] as $c){
        foreach(['M','L'] as $s){
            ProductVariation::create([
                'product_id' => $prod3->id,
                'color' => $c,
                'size' => $s,
                'sku' => strtoupper(Str::random(8)),
                'price' => $prod3->price,
                'stock' => rand(0,25)
            ]);
        }
    }
    }
}
