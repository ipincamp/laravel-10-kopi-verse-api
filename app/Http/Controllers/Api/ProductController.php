<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

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

            return ApiResponseHelper::success('Products fetched successfully.', Product::all());
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

            return ApiResponseHelper::success('Product created successfully.', $product);
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
            return ApiResponseHelper::error('Product not found.');
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
