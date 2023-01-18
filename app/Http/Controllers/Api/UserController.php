<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserStationResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function userInfo(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ],
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|current_password:sanctum',
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 401);
        }

        $validated = $validator->validated();

        $user = User::find(Auth::guard('sanctum')->id());

        if (!Hash::check($validated['old_password'], $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['The password is incorrect.'],
            ]);
        }

        if ($validated['old_password'] === $validated['new_password']) {
            throw ValidationException::withMessages([
                'new_password' => ['New password cannot be the same as old password.'],
            ]);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'message' => 'Password updated Successfully',
        ], 200);
    }

    public function stations(Request $request)
    {
        $user = User::find(Auth::guard('sanctum')->id());

        $chargingStations = $user->chargingStations()->latest()->get();

        return UserStationResource::collection($chargingStations);
    }
}
