<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Api\V1\Agent\Agent;
use Illuminate\Support\Facades\Hash;

class AgentAuthController extends Controller
{
    /**
     * Agent login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);

        // $credentials = request(['email', 'password']);

        $agent = Agent::where('email', $request->email)->first();

        if (!$agent || !Hash::check($request->password, $agent->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Login successful, return user data with token
        // $admin = Auth::guard('admin')->user();

        // Generate the access token
        $tokenResult = $agent->createToken('Personal Access Token', ['role:agent']);
        $token = $tokenResult->plainTextToken;


        // Build the user ability rules
        $userAbilityRules = [
            [
                'action' => 'manage',
                'subject' => 'all',
            ],
        ];

        return response()->json([
            'message' => 'Login successful',
            'userAbilityRules' => $userAbilityRules,
            'userData' => $agent,
            // 'userData' => new UserResource($admin),
            'accessToken' => $token,
        ]);
    }

    /**
     * Agent logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Revoke agent token
        Auth::guard('agent')->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logout successful']);
    }
}
