<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\CustomerOrder;
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
    public function addProductToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'toppings_id' => 'nullable|array', // Ensure toppings_id is an array
            'note' => 'nullable',
            'total_price' => 'required',
        ]);

        // Check if product exists
        if (!$validated['product_id']) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $product = Product::findOrFail($validated['product_id']);
        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        // Check if customer exists
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Check if order_id is provided
        if ($request->has('order_id') && $request->get('order_id') != null) {
            $order = Order::find($request->get('order_id'));
        } else {
            // Create a new order if order_id is not provided
            $order = Order::create([
                'order_number' => 'ORD' . time(),
                'receiver_name' => $customer->full_name,
                'receiver_address' => '',
                'payment_method' => 'Cash',
                'order_status' => 'Draft',
                'source' => 'Online',
                'customer_feedback' => '',
                'host_id' => $customer->id,
            ]);

            // Attach the customer to the order using the pivot table
            $order->customers()->attach($customer->id);
        }

        // Get the pivot record (CustomerOrder) for the customer and order
        $customerOrder = $order->customers()->where('customer_id', $customer->id)->first()->pivot;

        // Add order detail using the CustomerOrder pivot
        $orderDetail = $customerOrder->orderDetails()->create([
            'order_detail_number' => 'OD' . time(),
            'customer_order_id' => $customerOrder->id,
            'product_id' => $product->id,
            'parent_id' => null,
            'size' => $validated['size'],
            'quantity' => $validated['quantity'],
            'note' => $validated['note'],
            'total_price' => $validated['total_price'],
        ]);

        // Add toppings if provided
        if (isset($validated['toppings_id'])) {
            foreach ($validated['toppings_id'] as $toppingId) {
                $topping = Product::findOrFail($toppingId);
                $orderDetail->toppings()->create([
                    'order_detail_number' => 'ODTP' . time(),
                    'customer_order_id' => $customerOrder->id,
                    'product_id' => $topping->id,
                    'size' => 'S',
                    'quantity' => 1,
                    'note' => '',
                    'parent_id' => $orderDetail->id,
                ]);
            }
        }

        // Prepare the response data
        $return_data = [
            'order' => $order,
            'order_detail' => [
                'id' => $orderDetail->id,
                'order_detail_number' => $orderDetail->order_detail_number,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                ],
                'size' => $orderDetail->size,
                'quantity' => $orderDetail->quantity,
                'note' => $orderDetail->note,
                'total_price' => $orderDetail->total_price,
                'toppings' => $orderDetail->toppings,
            ],
        ];

        return response()->json([
            'message' => 'Product added to cart successfully.',
            'data' => $return_data
        ]);
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
