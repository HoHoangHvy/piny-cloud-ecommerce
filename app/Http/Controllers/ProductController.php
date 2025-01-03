<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ProductController extends BaseController
{
    /**
     * Display a listing of the products.
     */
    public function getProducts(Request $request)
    {
        // Get the number of items to fetch, defaulting to 10
        $pageSize = $request->input('page_size', 10);

        // Initialize the query builder for products
        $query = Product::select('products.id as product_id',
            'products.name as product_name',
            'products.price as product_price',
            'products.image as product_image',
            'categories.id as category_id',
            'categories.name as category_name',
            'categories.priority')
            ->join('category_product', 'category_product.product_id', '=', 'products.id') // Join with the pivot table
            ->join('categories', 'categories.id', '=', 'category_product.category_id')  // Join with the categories table
            ->where('products.status', 'active')
            ->where('products.is_topping', 0);

        // Apply name filter if present
        if ($request->has('search')) {
            $query->where('products.name', 'like', '%' . $request->input('search') . '%');
        }

        // Apply price range filters if present
        if ($request->has('min_price')) {
            $query->where('products.price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('products.price', '<=', $request->input('max_price'));
        }

        //Apply created_at filter if present
        if ($request->has('from_date')) {
            $query->whereDate('products.created_at', '>=', $request->input('created_at'));
        }

        if ($request->has('to_date')) {
            $query->whereDate('products.created_at', '<=', $request->input('created_at'));
        }

        // Apply category filter if present
        if ($request->has('category_id')) {
            $query->where('category_product.category_id', $request->input('category_id'));
        }

        // Apply cursor-based pagination if the 'last_product_id' parameter is present
        if ($request->has('last_product_id')) {
            $query->where('products.id', '>', $request->input('last_product_id'));
        }

        // Order by category priority
        $query->orderBy('categories.priority', 'asc')  // Assuming ascending priority
        ->orderBy('products.name', 'asc');  // Order products within the category

        // Fetch the products
        $products = $query->limit($pageSize)->get();

        $return_data = [];
        $prev_category_id = null;
        foreach($products as $product){
            if($prev_category_id != $product->category_id){
                $return_data[$product->category_id] = [
                    'category_name' => $product->category_name,
                    'category_id' => $product->category_id,
                    'priority' => $product->priority,
                ];
                $prev_category_id = $product->category_id;
            }
            $return_data[$product->category_id]['product_list'][] = [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'product_image' => $product->product_image ? asset('storage/' . $product->product_image) : null,
            ];
        }

        // Determine if there are more products to load
        $hasMore = $products->count() === $pageSize;

        // Get the last product's ID to use as a cursor for the next request
        $lastProductId = $products->isNotEmpty() ? $products->last()->product_id : null;

        return response()->json([
            'message' => 'Products retrieved successfully.',
            'data' => $this->toArray($return_data),
            'pagination' => [
                'last_product_id' => $lastProductId,  // Provide the ID of the last fetched product for cursor-based pagination
                'has_more' => $hasMore,               // Indicate if there are more products to load
            ],
        ], 200);
    }

    public function getProductDetail(String $id) {
        $product = Product::findOrFail($id);
        $toppingList = $product->toppings()
            ->select('id', 'name', 'price') // Select only the columns you need
            ->get()
            ->map(function ($topping) {
                return [
                    'id' => $topping->id,
                    'name' => $topping->name,
                    'price' => $topping->price,
                    'is_selected' => false
                ];
            });

        $return_data = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'topping_list' => $toppingList,
            'image_url' => $product->image ? asset('storage/' . $product->image) : null,
            'size_list' => [
                ['name' => 'S', 'price' => 0],
                ['name' => 'M', 'price' => $product->up_m_price],
                ['name' => 'L', 'price' => $product->up_l_price],
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $return_data
        ], 200);
    }

    public function toArray($data)
    {
        $returned_data = [];
        foreach($data as $row) {
            $returned_data[] = $row;
        }
        return $returned_data;
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Vlidate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'required|array',  // images must be an array
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',  // Each image must be a valid image file
            'status' => 'required|in:active,inactive',
            'price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'up_m_price' => 'nullable|numeric|min:0',
            'up_l_price' => 'nullable|numeric|min:0',
            'is_topping' => 'boolean',
            'categories_id' => 'required|array',  // Categories must be an array
        ]);

        // Create the product with validated data
        $product = Product::create($validated);

        // Attach categories to the product
        $product->categories()->attach($validated['categories_id']);

        // If the product is not a topping and toppings are provided, attach toppings
        if (!$validated['is_topping'] && $request->has('toppings_id')) {
            $product->toppings()->attach($request->get('toppings_id'));
        }

        // Handle image uploads
        if ($request->hasFile('images')) {
            $index = 0;
            // Loop through each image and store it
            foreach ($request->file('images') as $image) {
                // Store each image in 'public/products' directory
                $path = $image->store('products', 'public');

                // Create a record for each image in the product's images table
                $product->images()->create(['image_path' => $path]);

                // Set the first image as the main image (image attribute)
                if ($index === 0) {
                    $product->update(['image' => $path]);
                }
                $index++;
            }
        }

        // Return the response with the newly created product, including its images
        return response()->json(['message' => 'Product created successfully.', 'data' => $product->load('images')], 201);
    }
    public function getToppingOptions(Request $request): JsonResponse
    {
        $topping_name = $request->input('topping_name');
        if($topping_name != null) {
            // Retrieve all teams with only id and name fields
            $products = Product::where('is_topping', true)->where('name', 'like', '%' . $topping_name . '%')->get(['id', 'name', 'image']);
        } else {
            // Retrieve all teams with only id and name fields
            $products = Product::where('is_topping', true)->get(['id', 'name', 'image']);
        }
        // Add the total number of employees to each team
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image ? 'https://weevil-exotic-thankfully.ngrok-free.app/storage/' . $product->image : 'https://weevil-exotic-thankfully.ngrok-free.app/resources/assets/images/empty-image.jpg',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
    }

    public function getProductOptions(Request $request): JsonResponse
    {
        $product_name = $request->input('product_name');
        // Retrieve all teams with only id and name fields
        if($product_name != null) {
            $products = Product::where('name', 'like', '%' . $product_name . '%')->get();
        } else {
            $products = Product::all();
        }

        // Add the total number of employees to each team
        $products = $products->map(function ($product) {
            $toppingList = $product->toppings()
                ->select('id', 'name', 'price') // Select only the columns you need
                ->get()
                ->map(function ($topping) {
                    return [
                        'id' => $topping->id,
                        'name' => $topping->name,
                        'price' => $topping->price,
                        'is_selected' => false
                    ];
                });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'image_url' => $product->image ? 'https://weevil-exotic-thankfully.ngrok-free.app/storage/' . $product->image : 'https://weevil-exotic-thankfully.ngrok-free.app/resources/assets/images/empty-image.jpg',
                'price' => $product->price,
                'toppings' => $toppingList,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
    }
    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        $product = Product::with(['images', 'categories', 'toppings'])->findOrFail($id);

        // Map image paths to full URLs
        $product['categories_id'] = $product->categories()->pluck('id');
        $product['toppings_id'] = $product->toppings()->pluck('id');
        $product['images_list'] = $product->images->map(function ($image) {
            return [
                'id' => $image->id,
                'image_url' => asset('storage/' . $image->image_path),  // Generate the full URL
                'image_path' => $image->image_path,  // Original image path
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'images_new' => 'nullable|array', // Validate the Base64-encoded images list
            'status' => 'nullable|in:active,inactive',
            'price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'up_m_price' => 'nullable|numeric|min:0',
            'up_l_price' => 'nullable|numeric|min:0',
            'is_topping' => 'nullable|boolean',
            'categories_id' => 'nullable|array',
            'categories_id.*' => 'nullable|string|exists:categories,id',
            'toppings_id' => 'nullable|array',
            'toppings_id.*' => 'nullable|string|exists:products,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        // Attach categories to the product
        if (isset($validated['categories_id'])) {
            $product->categories()->sync($validated['categories_id']);
        }

        // If not a topping, attach toppings
        if (isset($validated['toppings_id']) && !$validated['is_topping']) {
            $product->toppings()->sync($validated['toppings_id']);
        }
        // Handle Base64 images
        if (isset($validated['images_new'])) {
            // Delete old images if necessary
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            $index = 0;
            // Save new images from Base64
            foreach ($validated['images_new'] as $base64Image) {
                $image_parts = explode(";base64,", $base64Image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $filename = uniqid('product_') . '.' . $image_type; // Generate a unique name
                $directory = storage_path('app/public/products'); // Target directory
                $path = "$directory/$filename";

                // Ensure the directory exists
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Save the decoded content to the file
                file_put_contents($path, $image_base64);

                // Save the relative path in the database
                $product->images()->create(['image_path' => "products/$filename"]);

                // Set the first image as the main image (image attribute)
                if ($index === 0) {
                    $product->update(['image' => "products/$filename"]);
                }
                $index++;
            }
        }

        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => $product->load('images', 'categories', 'toppings')
        ]);
    }

    /**
     * Remove the specified product from storage (soft delete).
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }

    /**
     * Restore a soft-deleted product.
     */
    public function restore(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return response()->json(['message' => 'Product restored successfully.']);
    }

    /**
     * Permanently delete a soft-deleted product.
     */
    public function forceDelete(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->forceDelete();

        return response()->json(['message' => 'Product permanently deleted.']);
    }

}

