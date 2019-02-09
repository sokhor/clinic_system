<?php

namespace App\Http\Controllers\Inventory;

use App\Domain\Inventory\Actions\PersistProduct;
use App\Domain\Inventory\Actions\UpdateProduct;
use App\Domain\Inventory\Actions\DeleteProduct;
use App\Domain\Inventory\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\Inventory\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $persistProduct;
    protected $updateProduct;
    protected $deleteProduct;

    public function __construct(
        PersistProduct $persistProduct,
        UpdateProduct $updateProduct,
        DeleteProduct $deleteProduct
    )
    {
        $this->persistProduct = $persistProduct;
        $this->updateProduct = $updateProduct;
        $this->deleteProduct = $deleteProduct;
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $product = $this->persistProduct->execute($request->all());

        return new ProductResource($product);
    }

    public function update(Request $request, $productId)
    {
        $this->authorize('edit', Product::class);

        $product = $this->updateProduct->execute($productId, $request->all());

        return new ProductResource($product);
    }

    public function destroy($productId)
    {
        $this->authorize('delete', Product::class);

        $this->deleteProduct->execute($productId);

        return response()->json(['message' => 'Product deleted']);
    }

    public function index()
    {
        $this->authorize('view', Product::class);

        $products = Product::paginate(request()->perPage);

        return ProductResource::collection($products);
    }
}
