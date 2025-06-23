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
        $products = json_decode(Storage::disk('local')->get('products.json'), true) ?? [];
        if (empty($products)) {
            throw new Exception('Invalid product list.');
        }

        return $products['products'];
    }
}
