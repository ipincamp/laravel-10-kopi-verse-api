<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
            if ($products->isEmpty()) {
                return ApiResponseHelper::success('No products found.');
            }

            return ApiResponseHelper::success('Products fetched successfully.', ProductResource::collection($products));
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            return ApiResponseHelper::success('Product created successfully.', new ProductResource($product));
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            if (!$product) {
                return ApiResponseHelper::error('Product not found.');
            }
            return ApiResponseHelper::success('Product fetched successfully.', new ProductResource($product));
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $product->update($request->validated());

            return ApiResponseHelper::success('Product updated successfully.', new ProductResource($product));
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            if (!$product) {
                return ApiResponseHelper::error('Product not found.');
            }
            $product->delete();

            return ApiResponseHelper::success('Product deleted successfully.');
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }
}
