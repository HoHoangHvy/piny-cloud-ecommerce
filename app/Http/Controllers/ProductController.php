<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'in:active,inactive',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'up_m_price' => 'nullable|numeric|min:0',
            'up_l_price' => 'nullable|numeric|min:0',
            'is_topping' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 's3');
            Storage::disk('s3')->setVisibility($imagePath, 'public');
            $validated['image'] = $imagePath;
        }

        $validated['id'] = (string) Str::uuid();

        $product = Product::create($validated);
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::find($product);
        if(!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = Product::find($product);
        if(!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'in:active,inactive',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'up_m_price' => 'nullable|numeric|min:0',
            'up_l_price' => 'nullable|numeric|min:0',
            'is_topping' => 'boolean',
        ]);
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image from S3
            if ($product->image) {
                Storage::disk('s3')->delete($product->image);
            }

            // Upload the new image
            $imagePath = $request->file('image')->store('products', 's3');
            Storage::disk('s3')->setVisibility($imagePath, 'public');
            $validatedData['image'] = $imagePath;
        }

        $product->update($validatedData);
        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product);
        if(!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        // Delete the image from S3
        if ($product->image) {
            Storage::disk('s3')->delete($product->image);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
