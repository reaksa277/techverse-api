<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Auth.login');
    }

    public function Register()
    {
        return view('Auth.register');
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'     => 'required|email',
                'password'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors(),
                    'data'      => []
                ], 201);
            }

            $user = User::where('email', $request->email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => ['email' => ['The provided credentials are incorrect.']],
                    'data'    => []
                ], 200);
            }

            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();
            }
            $token = $user->createToken('login-token')->plainTextToken;

            return response()->json([
                'success'   => true,
                'message'   => 'Login successful',
                'data'      => $user,
                'token'     => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Encrypt password
        ]);

        Auth::login($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success'   => true,
            'message'   => 'Logged out successfully',
            'data'      => []
        ], 201);
    }
}
