<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
class ProductVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        return [
            'product_id' => $product->id,
            'color' => $this->faker->randomElement(['Red','Blue','Black', null]),
            'size' => $this->faker->randomElement(['S','M','L','XL', null]),
            'sku' => strtoupper(Str::random(8)),
            'price' => rand(100,1000),
            'stock' => rand(0,50),
        ];
    }
}
