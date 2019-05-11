<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Inventory\Entities\Product;
use App\Domain\Inventory\ValueObjects\ProductComposition;

class UpdateProduct
{
    public function execute($productId, array $productData)
    {
        $product = Product::findOrFail($productId);

        $product->product_name = $productData['product_name'];
        $product->product_code = $productData['product_code'];
        $product->brand_name = $productData['brand_name'];
        $product->category_id = $productData['category_id'];
        $product->made_in = $productData['made_in'];
        $product->compositions = (new ProductComposition($productData['compositions']))->serialize();
        $product->laboratory = $productData['laboratory'];

        $product->save();

        return $product->fresh();
    }
}
