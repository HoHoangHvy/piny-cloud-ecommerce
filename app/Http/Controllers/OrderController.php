<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\CustomerOrder;
use App\Models\Order;
use App\Models\OrderDetail;
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
    public function deleteCart($orderId)
    {
        try {
            // Find the order by ID
            $order = Order::findOrFail($orderId);

            // Fetch all related pivot records (customers_orders) for this order
            $customerOrders = CustomerOrder::where('order_id', $orderId)->get();

            // Loop through each pivot record and delete the associated order details
            foreach ($customerOrders as $customerOrder) {
                // Delete toppings first (if any)
                foreach ($customerOrder->orderDetails()->where('parent_id', null)->get() as $orderDetail) {
                    // Delete toppings associated with this order detail
                    OrderDetail::where('parent_id', $orderDetail->id)->delete();
                }

                // Delete the order details
                $customerOrder->orderDetails()->delete();
            }

            // Detach all customers from the order (this will remove the pivot records)
            $order->customers()->detach();

            // Then delete the main order
            $order->delete();

            return response()->json(['message' => 'Order deleted successfully.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function createCart(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
        ]);

        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Create a new order
        $order = Order::create([
            'order_number' => 'ORD' . time(),
            'receiver_name' => $customer->full_name,
            'receiver_address' => '',
            'payment_method' => 'Cash',
            'order_status' => 'Draft',
            'type' => $validated['type'],
            'custom_name' => $request->get('custom_name'),
            'source' => 'Online',
            'customer_feedback' => '',
            'order_total' => 0,
            'host_id' => $customer->id,
        ]);

        // Attach the customer to the order using the pivot table
        $order->customers()->attach($customer->id);

        return response()->json(['message' => 'Cart created successfully.', 'data' => $order]);
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
            'order_ids' => 'array', // Ensure order_ids is an array
        ]);

        // Check if product exists
        $product = Product::findOrFail($validated['product_id']);
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        // Check if customer exists
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        $orderIds = $validated['order_ids']; // Array of order IDs
        $addedProducts = []; // To store the added products for each cart

        foreach ($orderIds as $orderId) {
            // Fetch the order
            $order = Order::find($orderId);

            // If the order doesn't exist, skip it
            if (!$order) {
                continue;
            }

            // Ensure the order belongs to the current customer
            $customerOrder = CustomerOrder::where('customer_id', $customer->id)
                ->where('order_id', $order->id)
                ->first();

            if (!$customerOrder) {
                continue; // Skip if the customer doesn't have access to this order
            }

            // Update the order total
            $order->order_total += $validated['total_price'];
            $order->save();

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

            // Prepare the response data for this cart
            $addedProducts[] = [
                'order_id' => $order->id,
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
        }

        return response()->json([
            'message' => 'Product added to multiple carts successfully.',
            'data' => $addedProducts,
        ]);
    }
    public function getExistedCart(Request $request) {
        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Get the latest order with status 'Draft' for the customer
        $orders = Order::where('host_id', $customer->id)
            ->where('order_status', 'Draft')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 404);
        }

        $return_data = [];

        foreach($orders as $order) {
            $return_data[] = [
                'order_id' => $order->id,
                'name' => $order->custom_name ? $order->custom_name : $order->order_number,
                'created_at' => $order->created_at,
                'host_id' => $order->host_id,
                'type' => $order->customers()->where('customer_id', $customer->id)->count() >= 2 ? 'Group' : 'Personal',
            ];
        }

        return response()->json([
            'message' => 'Cart fetched successfully.',
            'data' => $return_data
        ]);
    }
    public function loadCartDetail(Request $request, $id) {
        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Fetch the order
        $order = Order::findOrFail($id);

        // Ensure the order belongs to the current customer and is in 'Draft' status
        $customerOrder = CustomerOrder::where('customer_id', $customer->id)
            ->where('id', $order->host_id)
            ->whereHas('order', function ($query) {
                $query->where('order_status', 'Draft');
            })
            ->first();

        if (!$customerOrder) {
            return response()->json(['message' => 'Unauthorized or invalid order.'], 403);
        }

        $orderDetails = $customerOrder->orderDetails()
            ->where('parent_id', null)
            ->with('toppings.product') // Include topping product details
            ->get();

        $return_data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'host_id' => $order->host_id,
            'order_detail' => []
        ];

        foreach ($orderDetails as $orderDetail) {
            $return_data['order_detail'][] = [
                'id' => $orderDetail->id,
                'order_detail_number' => $orderDetail->order_detail_number,
                'product_name' => $orderDetail->product->name,
                'product_price' => $orderDetail->product->price,
                'size' => $orderDetail->size,
                'quantity' => $orderDetail->quantity,
                'note' => $orderDetail->note,
                'total_price' => $orderDetail->total_price,
                'toppings' => $orderDetail->toppings->map(function ($topping) {
                    return [
                        'id' => $topping->id,
                        'product_name' => $topping->product->name,
                        'product_price' => $topping->product->price,
                    ];
                }),
            ];
        }

        return response()->json([
            'message' => 'Cart details fetched successfully.',
            'data' => $return_data
        ]);
    }
    public function fetchCart(Request $request)
    {
        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Get the latest order with status 'Draft' for the customer
        $orders = Order::where('host_id', $customer->id)
            ->where('order_status', 'Draft')
            ->orderBy('updated_at', 'DESC')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 404);
        }

        $return_data = [];

        foreach($orders as $order) {
            $total_price = 0;
            // Fetch order details only if the relationship exists
            $orderCustomer = $order->customers()->where('customer_id', $customer->id)->first();

            if ($orderCustomer) {
                // Get order details if the relationship exists
                $orderDetails = $orderCustomer->pivot->orderDetails()
                    ->where('parent_id', null)
                    ->with('toppings.product') // Include topping product details
                    ->get();

                $data = [
                    'type' => $order->type,
                    'name' => !empty($order->custom_name) ? $order->custom_name : $order->order_number,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'date_created' => $order->created_at,
                    'host_id' => $order->host_id,
                    'count_product' => $orderDetails->count() ?? 0,
                    'order_detail' => []
                ];

                foreach ($orderDetails as $orderDetail) {
                    $total_price += $orderDetail->total_price;
                    $data['order_detail'][] = [
                        'id' => $orderDetail->id,
                        'order_detail_number' => $orderDetail->order_detail_number,
                        'product_name' => $orderDetail->product->name,
                        'product_price' => $orderDetail->product->price,
                        'size' => $orderDetail->size,
                        'quantity' => $orderDetail->quantity,
                        'image' => $orderDetail->product->product_image ? asset($orderDetail->product->product_image) : null,
                        'note' => $orderDetail->note,
                        'total_price' => $orderDetail->total_price,
                        'count_topping' => $orderDetail->toppings->count(),
                        'toppings' => $orderDetail->toppings->map(function ($topping) {
                            return [
                                'id' => $topping->id,
                                'product_name' => $topping->product->name,
                                'product_price' => $topping->product->price,
                            ];
                        }),
                    ];
                }
                $data['total_price'] = $total_price;
                $return_data[] = $data;
            }
        }

        return response()->json([
            'message' => 'Cart fetched successfully.',
            'data' => $return_data
        ]);
    }

    public function removeProductFromCart(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required | exists:orders,id', // Ensure the cart_id (order_id) exists
            'order_detail_id' => 'required | exists:order_details,id',
        ]);

        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Fetch the order (cart)
        $order = Order::findOrFail($validated['cart_id']);

        // Ensure the order belongs to the current customer
        $customerOrder = CustomerOrder::where('customer_id', $customer->id)
            ->where('order_id', $order->id)
            ->first();

        if (!$customerOrder) {
            return response()->json(['message' => 'Unauthorized or invalid order.'], 403);
        }

        // Fetch the order detail to delete
        $orderDetail = OrderDetail::findOrFail($validated['order_detail_id']);

        // Ensure the order detail belongs to the specified order
        if ($orderDetail->customer_order_id !== $customerOrder->id) {
            return response()->json(['message' => 'Unauthorized or invalid order detail.'], 403);
        }

        // Delete related toppings (if any)
        $orderDetail->toppings()->delete();

        // Update the order total
        $order->order_total -= $orderDetail->total_price;
        $order->save();

        // Delete the order detail
        $orderDetail->delete();

        return response()->json(['message' => 'Product removed from cart successfully.']);
    }
    public function removeToppingFromCart(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required | exists:orders,id', // Ensure the cart_id (order_id) exists
            'order_detail_id' => 'required | exists:order_details,id',
            'topping_id' => 'required | exists:order_details,id',
        ]);

        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Fetch the order (cart)
        $order = Order::findOrFail($validated['cart_id']);

        // Ensure the order belongs to the current customer
        $customerOrder = CustomerOrder::where('customer_id', $customer->id)
            ->where('order_id', $order->id)
            ->first();

        if (!$customerOrder) {
            return response()->json(['message' => 'Unauthorized or invalid order.'], 403);
        }

        // Fetch the order detail
        $orderDetail = OrderDetail::findOrFail($validated['order_detail_id']);

        // Ensure the order detail belongs to the specified order
        if ($orderDetail->customer_order_id !== $customerOrder->id) {
            return response()->json(['message' => 'Unauthorized or invalid order detail.'], 403);
        }

        // Fetch the topping to delete
        $topping = OrderDetail::findOrFail($validated['topping_id']);

        // Ensure the topping belongs to the specified order detail
        if ($topping->parent_id !== $orderDetail->id) {
            return response()->json(['message' => 'Unauthorized or invalid topping.'], 403);
        }

        // Update the order total
        $order->order_total -= $topping->total_price;
        $order->save();

        // Delete the topping
        $topping->delete();

        return response()->json(['message' => 'Topping removed from cart successfully.']);
    }
    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required | string | unique:orders,order_number | max:255',
            'receiver_name' => 'required | string | max:255',
            'receiver_address' => 'required | string | max:255',
            'payment_method' => 'required | in:Banking,Cash',
            'payment_status' => 'required | in:pending,paid',
            'order_status' => 'required | in:Wait for Approval, In Progress, Delivering, Delivered, Completed, Cancelled',
            'date_created' => 'required | date',
            'order_total' => 'nullable | numeric | min:0',
            'rate' => 'nullable | integer | min:0 | max:5',
            'customer_feedback' => 'nullable | string | max:255',
            'host_id' => 'required | uuid | exists:customers,id',
            'manually_created_by' => 'nullable | uuid | exists:users,id',
            'source' => 'required | in:Offline,Online',
            'team_id' => 'required | uuid | exists:teams,id',
            'created_by' => 'required | uuid | exists:users,id',
        ]);

        $order = Order::create($validated);

        return response()->json(['message' => 'Order created successfully . ', 'data' => $order], 201);
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
            'order_number' => 'nullable | string | unique:orders,order_number,' . $id . ' | max:255',
            'receiver_name' => 'nullable | string | max:255',
            'receiver_address' => 'nullable | string | max:255',
            'payment_method' => 'nullable | in:Banking,Cash',
            'payment_status' => 'nullable | in:pending,paid',
            'order_status' => 'nullable | in:Wait for Approval, In Progress, Delivering, Delivered, Completed, Cancelled',
            'date_created' => 'nullable | date',
            'order_total' => 'nullable | numeric | min:0',
            'rate' => 'nullable | integer | min:0 | max:5',
            'customer_feedback' => 'nullable | string | max:255',
            'host_id' => 'nullable | uuid | exists:customers,id',
            'manually_created_by' => 'nullable | uuid | exists:users,id',
            'source' => 'nullable | in:Offline,Online',
            'team_id' => 'nullable | uuid | exists:teams,id',
            'created_by' => 'nullable | uuid | exists:users,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validated);

        return response()->json(['message' => 'Order updated successfully . ', 'data' => $order]);
    }

    /**
     * Remove the specified order from storage (soft delete).
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully . ']);
    }

    /**
     * Restore a soft-deleted order.
     */
    public function restore(string $id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();

        return response()->json(['message' => 'Order restored successfully . ']);
    }

    /**
     * Permanently delete a soft-deleted order.
     */
    public function forceDelete(string $id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->forceDelete();

        return response()->json(['message' => 'Order permanently deleted . ']);
    }
}
