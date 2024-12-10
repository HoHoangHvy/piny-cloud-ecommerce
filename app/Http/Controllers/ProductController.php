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

class ProductController extends BaseController
{
    /**
     * Display a listing of the products.
     */
    public function getProducts(Request $request)
    {
        // Get pagination size from the request, or set a default value
        $pageSize = $request->input('page_size', 10); // Default: 10 items per page

        // Initialize the query builder for products
        $query = Product::select('id', 'name', 'price', 'image')
            ->where('status', 'active')
            ->where('is_topping', 0);

        // Filter by 'name' if it's passed in the request
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by 'min_price' and 'max_price' if they are passed in the request
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Filter by 'category_id' if passed
        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('id', $request->input('category_id'));
            });
        }

        // Fetch paginated products with the applied filters
        $products = $query->paginate($pageSize);

        // Transform the collection
        $products->getCollection()->transform(function ($product) {
            // Add categories_id and image_url to each product
            $product->categories_id = $product->categories()->pluck('id');
            $product->image_url = $product->image ? asset('storage/' . $product->image) : null;

            return $product;
        });

        return response()->json([
            'message' => 'Products retrieved successfully.',
            'data' => $products->items(), // The actual paginated data
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ], 200);
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
    public function getToppingOptions(): JsonResponse
    {
        // Retrieve all teams with only id and name fields
        $products = Product::where('is_topping', true)->get(['id', 'name']);

        // Add the total number of employees to each team
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name
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
            'toppings_id.*' => 'nullable|string|exists:toppings,id',
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

