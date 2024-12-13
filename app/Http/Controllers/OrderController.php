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
    public function deleteCart(Request $request, $id)
    {
        $validated = $request->validate([
            'order_id' => 'required | exists:orders,id',
        ]);

        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Fetch the order to delete
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

        // Delete the order
        $order->delete();

        return response()->json(['message' => 'Cart deleted successfully.']);
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
            $order->order_total += $validated['total_price'];
            $order->save();
        } else {
            // Create a new order if order_id is not provided
            $order = Order::create([
                'order_number' => 'ORD' . time(),
                'receiver_name' => $customer->full_name,
                'receiver_address' => '',
                'payment_method' => 'Cash',
                'order_status' => 'Draft',
                'type' => 'Personal',
                'source' => 'Online',
                'customer_feedback' => '',
                'order_total' => $validated['total_price'],
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
                    'name' => $order->custom_name ? $order->custom_name : $order->order_number,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'host_id' => $order->host_id,
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
            'order_detail_id' => 'required | exists:order_details,id',
        ]);

        $currentUser = auth()->user();
        $customer = Customer::where('user_id', $currentUser->id)->first();

        if (!$customer) {
            return response()->json(['message' => 'Customer not found . '], 404);
        }

        // Fetch the order detail to delete
        $orderDetail = OrderDetail::findOrFail($validated['order_detail_id']);

        // Ensure the order belongs to the current customer and is in 'Draft' status
        $customerOrder = CustomerOrder::where('customer_id', $customer->id)
            ->where('id', $orderDetail->customer_order_id)
            ->whereHas('order', function ($query) {
                $query->where('order_status', 'Draft');
            })
            ->first();

        if (!$customerOrder) {
            return response()->json(['message' => 'Unauthorized or invalid order detail . '], 403);
        }

        // Delete related toppings (if any)
        $orderDetail->toppings()->delete();

        // Delete the order detail
        $orderDetail->delete();

        return response()->json(['message' => 'Product removed from cart successfully . ']);
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
