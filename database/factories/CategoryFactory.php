<?php

namespace Database\Factories;

use App\Models\Category;
use Database\Factories\Concerns\ImportProducts;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    use ImportProducts;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $products = $this->getProducts();

        $categories = array_column($products, 'category');

        return [
            'name' => $this->faker->unique()->randomElement($categories)
        ];
    }
}
