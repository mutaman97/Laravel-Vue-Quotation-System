<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\Admin\AgentStock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch stock entries with optional filters
        $stocks = AgentStock::with('product', 'agent');

        // Filter by agent ID if provided
        if ($request->has('agent_id')) {
            $stocks->where('agent_id', $request->agent_id);
        }

        // Filter by product ID if provided
        if ($request->has('product_id')) {
            $stocks->where('product_id', $request->product_id);
        }

        // Return paginated stocks
        return response()->json($stocks->paginate(10), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $stock = AgentStock::create($validatedData);

        return response()->json([
            'message' => 'Stock assigned successfully.',
            'stock' => $stock->load('product', 'agent'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stock = AgentStock::with('product', 'agent')->findOrFail($id);

        return response()->json($stock, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stock = AgentStock::findOrFail($id);

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $stock->update($validatedData);

        return response()->json([
            'message' => 'Stock updated successfully.',
            'stock' => $stock->load('product', 'agent'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = AgentStock::findOrFail($id);

        $stock->delete();

        return response()->json([
            'message' => 'Stock entry deleted successfully.',
        ], 200);
    }
}
