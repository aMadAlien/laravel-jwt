<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register'
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('name', $request->name)
                    ->orWhere('email', $request->email)
                    ->get();

        if (count($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'This name or email is already taken'
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        auth()->login($user);

        return self::respondWithToken();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found. Do not have an account? Register!'
            ]);
        }

        return self::respondWithToken();
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function refresh()
    {
        return self::respondWithToken();
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    public function respondWithToken()
    {
        return response()->json([
            'access_token' => auth()->refresh(),
            'type' => 'Bearer',
            'expires_in' => \Config::get('jwt.ttl') * 60
        ]);
    }
}