<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 401);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        Auth::guard('backpack')->login($user);

        $request->session()->regenerate();

        return response()->json([
            'message' => 'User Created Successfully',
            'token' => $user->createToken("react")->plainTextToken
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 401);
        }

        $validated = $validator->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email or Password does not match.'],
            ]);
        }

        Auth::guard('backpack')->login($user);

        $request->session()->regenerate();

        return response()->json([
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("react")->plainTextToken,
            'is_admin' => $user->hasRole('admin'),
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $user->currentAccessToken()->delete();

        Auth::guard('backpack')->logout($user);

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'User Logout Successfully',
        ], 200);
    }
}
