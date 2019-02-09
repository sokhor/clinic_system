<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Inventory\Entities\Product;
use App\Domain\Inventory\ValueObjects\ProductComposition;

class PersistProduct
{
    public function execute(array $productData)
    {
        $product = Product::create([
            'product_name' => $productData['product_name'],
            'product_code' => $productData['product_code'],
            'brand_name' => $productData['brand_name'],
            'category_id' => $productData['category_id'],
            'made_in' => $productData['made_in'],
            'compositions' => (new ProductComposition($productData['compositions']))->serialize(),
            'laboratory' => $productData['laboratory'],
        ]);

        return $product;
    }
}