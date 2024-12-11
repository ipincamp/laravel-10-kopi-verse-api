<?php

namespace App\Http\Controllers\Api\Product;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Models\Product;

class ChangeAvailableProductController extends Controller
{
    /**
     * Handle the incoming request.
     * !Tested
     */
    public function __invoke(Product $product)
    {
        try {
            $product->available = !$product->available;
            $product->save();

            return ApiResponseHelper::success(
                'Product availability changed successfully',
                new ProductDetailResource($product),
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }
}
