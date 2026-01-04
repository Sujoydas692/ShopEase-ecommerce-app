<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductDetailsFactory extends Factory
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
            'image1' => $product ? $product->image : null,
            'image2' => 'https://picsum.photos/seed/' . $this->faker->unique()->numberBetween(1, 999999) . '/540/600',
            'image3' => 'https://picsum.photos/seed/' . $this->faker->unique()->numberBetween(1, 999999) . '/540/600',
            'image4' => 'https://picsum.photos/seed/' . $this->faker->unique()->numberBetween(1, 999999) . '/540/600',
            'description' => $this->faker->paragraph(4),
            'color' => implode(',', $this->faker->randomElements(['Red', 'Blue', 'Green', 'Black', 'White'], rand(0,3))),
            'size'  => implode(',', $this->faker->randomElements(['S', 'M', 'L', 'XL'], rand(0,3))),
            'stock' => rand(1, 100),
        ];
    }
}
