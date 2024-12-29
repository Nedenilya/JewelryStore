<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        try {
            $user = new User();
            $user->email = $credentials['email'];
            $user->password = Hash::make($credentials['password']);
            $user->save();

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $response = [
                'success' => true,
                'message' => "Customer register successfully",
                'token' => $token,
                'user' => $user,
            ];
        } catch (QueryException $ex) {
            return response()->json([
                'status' => 'Error',
                'message' => $ex->getMessage()
            ]);
        }

        Auth::setUser($user);

        return response()->json($response);
    }
}
