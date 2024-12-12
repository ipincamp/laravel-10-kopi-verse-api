<?php

namespace App\Http\Controllers\Api\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Models\Product;

class ChangeAvailableProductController extends Controller
{
    /**
     * Update available status of the product.
     */
    public function __invoke(Product $product)
    {
        try {
            $product->available = !$product->available;
            $product->save();

            return ApiResponse::send(
                200,
                'Product availability changed successfully',
                new ProductDetailResource($product),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
