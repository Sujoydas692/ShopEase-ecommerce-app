<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSlider>
 */
class ProductSliderFactory extends Factory
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
            'title' => $this->faker->sentence(3),
            'short_desc' => $this->faker->sentence(8),
            'price' => rand(100,1000),
            'image' => 'https://picsum.photos/seed/' . $this->faker->unique()->numberBetween(1, 999999) . '/540/600',
        ];
    }
}
