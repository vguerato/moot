<?php

namespace Database\Factories;

use App\Models\Brand;
use Database\Factories\Concerns\ImportProducts;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
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

        $brands = array_column($products, 'brand');

        return [
            'name' => $this->faker->unique()->randomElement($brands)
        ];
    }
}
