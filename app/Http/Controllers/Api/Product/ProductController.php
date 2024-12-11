<?php

namespace App\Http\Controllers\Api\Product;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * !Tested
     */
    public function index()
    {
        try {
            $productDrinks = Product::where('category', 'drink')->get();
            $productFoods = Product::where('category', 'food')->get();

            return ApiResponseHelper::success(
                'Products fetched successfully.',
                [
                    'drinks' => $productDrinks->map(function ($product) {
                        return new ProductResource($product);
                    }),
                    'foods' => $productFoods->map(function ($product) {
                        return new ProductResource($product);
                    }),
                    'total_products' => Product::count(),
                ],
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * !Tested
     */
    public function store(CreateProductRequest $request)
    {
        try {
            $this->authorize('create', Product::class);

            $product = Product::create($request->validated());

            return ApiResponseHelper::success(
                'Product created successfully.',
                new ProductResource($product),
                201,
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * !Tested
     */
    public function show(Product $product)
    {
        try {
            return ApiResponseHelper::success(
                'Product fetched successfully.',
                new ProductDetailResource($product),
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     * !Tested
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->authorize('update', Product::class);

            $product->update($request->validated());

            return ApiResponseHelper::success(
                'Product updated successfully.',
                new ProductDetailResource($product),
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * !Tested
     */
    public function destroy(Product $product)
    {
        try {
            $this->authorize('delete', $product);

            $product->delete();

            return ApiResponseHelper::success('Product deleted successfully.');
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }
}
