<?php

namespace App\Http\Controllers\Api\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateStatusOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Get all own orders, even if they are not paid.
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', Order::class);

            $user = Auth::user();
            $orders = Order::where('user_id', $user->id)->get();

            if ($orders->isEmpty()) {
                return ApiResponse::send(404, 'No orders found.');
            }

            return ApiResponse::send(200, 'Orders retrieved successfully.', $orders);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            $this->authorize('create', Order::class);

            $user = Auth::user();
            $cartItems = Cart::with('items')->where('user_id', $user->id)->get()->pluck('items')->flatten();

            if ($cartItems->isEmpty()) {
                return ApiResponse::send(400, 'Cart is empty.');
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total' => 0,
            ]);
            $totalAmount = 0;

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $totalPrice = $product->price * $cartItem->quantity;
                $totalAmount += $totalPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'sub_total' => $totalPrice,
                ]);

                $cartItem->delete();
            }

            $barcode = 'CSORD-' . now()->format('YmdHis') . $totalAmount;
            $order->update([
                'total' => $totalAmount,
                'barcode' => $barcode,
            ]);

            return ApiResponse::send(201, 'Order created successfully.', $order);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Show the specified order.
     * Cashier only can show the order.
     */
    public function show(Order $order)
    {
        try {
            $this->authorize('view', $order);

            return ApiResponse::send(200, 'Order retrieved successfully.', $order);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Update status of the specified order.
     * Cashier only can update the status of the order.
     */
    public function update(UpdateStatusOrderRequest $request, Order $order)
    {
        try {
            $this->authorize('update', Order::class);

            if ($order->status === 'wait') {
                $order->update(['notes' => $request->notes]);
            }

            $invalidTransitions = [
                'wait' => ['ready', 'done'],
                'prep' => ['wait', 'done'],
                'ready' => ['wait', 'prep'],
                'done' => ['wait', 'prep', 'ready', 'cancel'],
                'cancel' => ['wait', 'prep', 'ready', 'done'],
            ];

            if (in_array($request->status, $invalidTransitions[$order->status])) {
                return ApiResponse::send(400, 'Invalid order status transition.');
            }

            $order->update(['status' => $request->status]);

            return ApiResponse::send(200, 'Order status updated successfully.', $order);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
