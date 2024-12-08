<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::withTrashed()->get(); // Include soft-deleted records
        return response()->json($categories);
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:Food,Drink,Topping',
            'team_id' => 'required|uuid|exists:teams,id',
        ]);

        $category = Category::create($validated);

        return response()->json(['message' => 'Category created successfully.', 'data' => $category], 201);
    }

    /**
     * Display the specified category.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|in:Food,Drink,Topping',
            'team_id' => 'nullable|uuid|exists:teams,id',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return response()->json(['message' => 'Category updated successfully.', 'data' => $category]);
    }

    /**
     * Remove the specified category from storage (soft delete).
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }

    /**
     * Restore a soft-deleted category.
     */
    public function restore(string $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return response()->json(['message' => 'Category restored successfully.']);
    }

    /**
     * Permanently delete a soft-deleted category.
     */
    public function forceDelete(string $id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return response()->json(['message' => 'Category permanently deleted.']);
    }
}
