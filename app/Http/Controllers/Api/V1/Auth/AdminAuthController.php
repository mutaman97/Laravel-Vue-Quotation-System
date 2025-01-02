<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Models\Api\V1\Admin\Admin;

class AdminAuthController extends Controller
{
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
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

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Login successful, return user data with token
        // $admin = Auth::guard('admin')->user();

        // Generate the access token
        $tokenResult = $admin->createToken('Personal Access Token', ['role:admin']);
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
            'userData' => $admin,
            // 'userData' => new UserResource($admin),
            'accessToken' => $token,
        ]);
    }

    /**
     * Admin logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Revoke admin token
        Auth::guard('admin')->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logout successful']);
    }
}
