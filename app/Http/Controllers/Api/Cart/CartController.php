<?php

namespace App\Http\Controllers\Api\Cart;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddItemToCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Get the cart items.
     */
    public function index()
    {
        try {
            $this->authorize('view', Auth::user()->cart);

            $cartItems = Auth::user()->cart->load('items.product');

            return ApiResponse::send(
                200,
                'Cart items fetched successfully.',
                new CartResource($cartItems),
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Add a product to the cart.
     */
    public function store(AddItemToCartRequest $request)
    {
        try {
            $this->authorize('create', Auth::user()->cart);

            $cart = Auth::user()->cart;
            $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $cartItem->quantity + (int)$request->quantity,
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }

            return ApiResponse::send(
                201,
                'Product added to cart successfully.',
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request)
    {
        try {
            $this->authorize('update', Auth::user()->cart);

            $cart = Auth::user()->cart;

            foreach ($request->items as $item) {
                $cartItem = $cart->items()->where('product_id', $item['product_id'])->first();
                $item['quantity'] == 0 ? $cartItem->delete() : $cartItem->update([
                    'quantity' => $item['quantity'],
                ]);
            }

            return ApiResponse::send(
                200,
                'Cart updated successfully.',
            );
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
