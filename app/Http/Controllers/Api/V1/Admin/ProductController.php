<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Api\V1\Admin\Product;
use App\Http\Requests\Api\V1\Admin\StoreProductRequest;
use App\Http\Requests\Api\V1\Admin\UpdateProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get paginated list of products
        $products = Product::query();

        // Optional filtering by name
        if ($request->has('name')) {
            $products->where('name', 'like', '%' . $request->name . '%');
        }

        // Return paginated response
        return response()->json($products->paginate(10), 200);
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
    public function store(StoreProductRequest $request)
    {
        // Validate and create the product
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Return the product details
        return response()->json($product, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Validate and update the product
        $product->update($request->validated());

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the product
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.'
        ], 200);
    }
}
