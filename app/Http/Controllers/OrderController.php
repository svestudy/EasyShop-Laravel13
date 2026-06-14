<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout()
    {
        $user = auth()->user();
        $addresses = $user->addresses;
        $defaultAddress = $addresses->firstWhere('is_default', true);

        return view('checkout', compact('addresses', 'defaultAddress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        $user = auth()->user();
        $address = Address::findOrFail($request->address_id);

        // Get cart items from session or implement your cart logic
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return back()->with('error', 'Your cart is empty');
        }

        // Calculate total
        $totalAmount = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . Str::upper(Str::random(10)),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_address' => $address->toArray(),
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Reduce stock
            $product = Product::find($item['product_id']);
            $product->decrement('stock', $item['quantity']);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('order.confirmation', $order)->with('success', 'Order placed successfully!');
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('order-confirmation', compact('order'));
    }

    public function myOrders()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('my-orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('order-details', compact('order'));
    }
}
