<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Inventory\Entities\Product;

class DeleteProduct
{
    public function execute($productId)
    {
        $product = Product::findOrFail($productId);

        $product->delete();

        return $product;
    }
}