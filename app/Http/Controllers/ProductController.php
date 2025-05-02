<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::all();
    return response()->json($products);
}
public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    $product->delete();

    return response()->json(['message' => 'Product deleted successfully']);
}

public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|required|string',
        'price' => 'sometimes|required|numeric',
        'stars' => 'sometimes|required|integer|min:1|max:5',
        'location' => 'sometimes|required|string',
        
        'type_id' => 'sometimes|required|integer|exists:types,id',
        'category_id' => 'sometimes|required|integer|exists:categories,id', // Validate category_id
    ]);

    $product->update($request->all());

    return response()->json($product);
}


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:2048' // multiple images
    ]);

    $product = Product::create($request->only('name', 'price', 'description', 'category_id'));

    // Save each uploaded image
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('product_images', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
            ]);
        }
    }

    $product->load('images');

    return response()->json([
        'message' => 'Product created',
        'product' => $product,
        'images' => $product->images->pluck('image_path'),
    ]);
}

public function show($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    return response()->json($product);
}


    //
    public function getByType($type_id, Request $request)
{
    $limit = $request->input('limit', 10);
    $offset = $request->input('offset', 0);

    $query = Product::where('type_id', $type_id);
    $total = $query->count();

    $products = $query->skip($offset)->take($limit)->get();

    return response()->json([
        'total_size' => $total,
        'type_id' => (int) $type_id,
        'offset' => (int) $offset,
        'products' => $products
    ]);
}
}
