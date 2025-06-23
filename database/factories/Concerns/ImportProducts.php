<?php

namespace Database\Factories\Concerns;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait ImportProducts
{
    /**
     * Import product list
     * @throws Exception
     * @return array
     */
    protected function getProducts(): array
    {
        $filePath = base_path('products.json');
        if (!file_exists($filePath)) {
            throw new Exception('products.json not found.');
        }

        $products = json_decode(file_get_contents($filePath), true) ?? [];
        if (empty($products)) {
            throw new Exception('Invalid product list.');
        }

        return $products['products'];
    }
}
