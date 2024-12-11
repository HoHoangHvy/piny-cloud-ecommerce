<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'createdBy', 'manuallyCreatedBy', 'team'])->get();
        return response()->json($orders);
    }
    public function addProductToCart(Request $request) {
        $validated = $request->validate([
            'product_id' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'toppings_id' => 'nullable',
            'note' => 'nullable',
        ]);

        if($validated['product'] == null) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $product = Product::findOrFail($validated['product']);

        if($request->has('order_id') && $request->get('order_id') != null) {
            $order = Order::find($request->get('order_id'));
        } else {
            $currentUser = auth()->user();
            $order = Order::create([
                'order_number' => 'ORD' . time(),
                'receiver_name' => $currentUser->name,
                'receiver_address' => '',
                'payment_method' => 'Cash',
                'payment_status' => 'pending',
                'order_status' => 'Wait For Approval',
                'date_created' => now(),
                'order_total' => 0,
                'rate' => 0,
                'customer_feedback' => null,
                'host_id' => null,
                'manually_created_by' => null,
                'source' => 'Online',
            ]);
        }
    }
    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|unique:orders,order_number|max:255',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'payment_method' => 'required|in:Banking,Cash',
            'payment_status' => 'required|in:pending,paid',
            'order_status' => 'required|in:Wait For Approval,In Progress,Delivering,Delivered,Completed,Cancelled',
            'date_created' => 'required|date',
            'order_total' => 'nullable|numeric|min:0',
            'rate' => 'nullable|integer|min:0|max:5',
            'customer_feedback' => 'nullable|string|max:255',
            'host_id' => 'required|uuid|exists:customers,id',
            'manually_created_by' => 'nullable|uuid|exists:users,id',
            'source' => 'required|in:Offline,Online',
            'team_id' => 'required|uuid|exists:teams,id',
            'created_by' => 'required|uuid|exists:users,id',
        ]);

        $order = Order::create($validated);

        return response()->json(['message' => 'Order created successfully.', 'data' => $order], 201);
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        $order = Order::with(['customer', 'createdBy', 'manuallyCreatedBy', 'team'])->findOrFail($id);

        return response()->json($order);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'order_number' => 'nullable|string|unique:orders,order_number,' . $id . '|max:255',
            'receiver_name' => 'nullable|string|max:255',
            'receiver_address' => 'nullable|string|max:255',
            'payment_method' => 'nullable|in:Banking,Cash',
            'payment_status' => 'nullable|in:pending,paid',
            'order_status' => 'nullable|in:Wait For Approval,In Progress,Delivering,Delivered,Completed,Cancelled',
            'date_created' => 'nullable|date',
            'order_total' => 'nullable|numeric|min:0',
            'rate' => 'nullable|integer|min:0|max:5',
            'customer_feedback' => 'nullable|string|max:255',
            'host_id' => 'nullable|uuid|exists:customers,id',
            'manually_created_by' => 'nullable|uuid|exists:users,id',
            'source' => 'nullable|in:Offline,Online',
            'team_id' => 'nullable|uuid|exists:teams,id',
            'created_by' => 'nullable|uuid|exists:users,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return response()->json(['message' => 'Order updated successfully.', 'data' => $order]);
    }

    /**
     * Remove the specified order from storage (soft delete).
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.']);
    }

    /**
     * Restore a soft-deleted order.
     */
    public function restore(string $id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();

        return response()->json(['message' => 'Order restored successfully.']);
    }

    /**
     * Permanently delete a soft-deleted order.
     */
    public function forceDelete(string $id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->forceDelete();

        return response()->json(['message' => 'Order permanently deleted.']);
    }
}
