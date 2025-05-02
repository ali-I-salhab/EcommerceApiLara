<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Get all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Create a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category, 201);
    }

    // Edit an existing category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json($category);
    }
    public function store_image(Request $request)
    {
        // Validate the request (ensure an image is included)
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Store the image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public'); // Store in the 'categories' directory in public storage
        }

        // Create the category with the image path
        $category = Category::create([
            'name' => $request->name,
            'image' => $imagePath ?? null, // Assign the image path if available
        ]);

        return response()->json([
            'message' => 'Category created successfully!',
            'category' => $category
        ], 201);
    }

    // Update a category's image
    public function update_image(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the category
        $category = Category::findOrFail($id);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        // Update the category
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully!',
            'category' => $category
        ]);
    }
    // Delete a category
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
