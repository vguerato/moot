<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\Concerns\ImportProducts;
use Exception;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use ImportProducts;

    /**
     * Seed the application's database.
     * @throws Exception
     */
    public function run(): void
    {
        $products = $this->getProducts();

        $uniqueCategories = array_unique(array_column($products, 'category'));
        $uniqueBrands = array_unique(array_column($products, 'brand'));

        $categories = Category::factory()->count(count($uniqueCategories))
            ->create()
            ->pluck('id', 'name')
            ->toArray();


        $brands = Brand::factory()->count(count($uniqueBrands))
            ->create()
            ->pluck('id', 'name')
            ->toArray();

        foreach ($products as $productData) {
            Product::create([
                'name' => $productData['name'],
                'price' => $productData['price'],
                'category_id' => $categories[$productData['category']],
                'brand_id' => $brands[$productData['brand']],
            ]);
        }
    }
}
