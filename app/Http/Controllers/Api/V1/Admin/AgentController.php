<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Api\V1\Agent\Agent;
use App\Http\Requests\Api\V1\Agent\StoreAgentRequest;
use App\Http\Requests\Api\V1\Agent\UpdateAgentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch agents with optional filters
        $agents = Agent::query();

        // Filter by name if provided
        if ($request->has('name')) {
            $agents->where('name', 'like', '%' . $request->name . '%');
        }

        // Return paginated agents
        return response()->json($agents->paginate(10), 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgentRequest $request)
    {
        // Validate and create an agent
        $agent = Agent::create($request->validated());

        return response()->json([
            'message' => 'Agent created successfully.',
            'agent' => $agent
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agent $agent)
    {
        // Return the agent details
        return response()->json($agent, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        // Validate and update the agent
        $agent->update($request->validated());

        return response()->json([
            'message' => 'Agent updated successfully.',
            'agent' => $agent
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agent $agent)
    {
        // Delete the agent
        $agent->delete();

        return response()->json([
            'message' => 'Agent deleted successfully.'
        ], 200);
    }
}
