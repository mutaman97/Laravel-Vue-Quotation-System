<?php

namespace App\Http\Controllers\Api\V1\Agent;

use App\Models\Api\V1\Agent\Quotation;
use App\Http\Requests\Api\V1\Agent\StoreQuotationRequest;
use App\Http\Requests\Api\V1\Agent\UpdateQuotationRequest;
use App\Http\Controllers\Controller;
use App\Models\Api\V1\Admin\AgentStock;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agentId = auth()->user()->id;

        // Fetch quotations for the logged-in agent
        $quotations = Quotation::where('agent_id', $agentId)
            ->with('items.product')
            ->paginate(10);

        return response()->json($quotations, 200);
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
    public function store(StoreQuotationRequest $request)
    {
        $agentId = auth()->user()->id;

        $validated = $request->validated();

        // Create a new quotation
        $quotation = Quotation::create([
            'agent_id' => $agentId,
            'total' => 0, // This will be calculated below
        ]);

        $total = 0;

        foreach ($validated['items'] as $item) {
            $stock = AgentStock::where('agent_id', $agentId)
                ->where('product_id', $item['product_id'])
                ->first();

            if (!$stock || $stock->quantity < $item['quantity']) {
                return response()->json([
                    'error' => "Insufficient stock for product ID: {$item['product_id']}",
                ], 400);
            }

            // Add items to the quotation
            $quotation->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $stock->product->price,
            ]);

            // Deduct from stock
            $stock->decrement('quantity', $item['quantity']);

            // Calculate total
            $total += $stock->product->price * $item['quantity'];
        }

        // Update quotation total
        $quotation->update(['total' => $total]);

        return response()->json([
            'message' => 'Quotation created successfully.',
            'quotation' => $quotation->load('items.product'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        $agentId = auth()->user()->id;

        if ($quotation->agent_id !== $agentId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($quotation->load('items.product'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $agentId = auth()->user()->id;

        if ($quotation->agent_id !== $agentId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validated();

        // Update quotation details
        $quotation->update([
            'total' => 0, // This will be recalculated
        ]);

        // Remove existing items
        $quotation->items()->delete();

        $total = 0;

        foreach ($validated['items'] as $item) {
            $stock = AgentStock::where('agent_id', $agentId)
                ->where('product_id', $item['product_id'])
                ->first();

            if (!$stock || $stock->quantity < $item['quantity']) {
                return response()->json([
                    'error' => "Insufficient stock for product ID: {$item['product_id']}",
                ], 400);
            }

            // Add new items to the quotation
            $quotation->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $stock->product->price,
            ]);

            // Deduct from stock
            $stock->decrement('quantity', $item['quantity']);

            // Calculate total
            $total += $stock->product->price * $item['quantity'];
        }

        // Update quotation total
        $quotation->update(['total' => $total]);

        return response()->json([
            'message' => 'Quotation updated successfully.',
            'quotation' => $quotation->load('items.product'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        $agentId = auth()->user()->userable->id;

        if ($quotation->agent_id !== $agentId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Restore stock quantities
        foreach ($quotation->items as $item) {
            $stock = AgentStock::where('agent_id', $agentId)
                ->where('product_id', $item->product_id)
                ->first();

            if ($stock) {
                $stock->increment('quantity', $item->quantity);
            }
        }

        $quotation->delete();

        return response()->json([
            'message' => 'Quotation deleted successfully.',
        ], 200);
    }
}
