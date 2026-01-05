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

    public function showRegister() {
        
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

            return response()->json([
                'success'   => true,
                'message'   => 'Login successful',
                'data'      => $user
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
        $validator = Validator::make($request->all(), [
            'name'            => 'required',
            'email'           => 'required|email',
            'password'        => 'required',
            'confirmPassword' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message'   => $validator->errors(),
                'data'      => []
            ], 201);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'success'   => false,
                'message'   => ['email' => ['Email has already been taken.']],
                'data'      => []
            ], 201);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Encrypt password
        ]);

//        $token = $user->createToken('auth_token')->plainTextToken;
        $request->session()->regenerate();

        return response()->json([
            'success'   => true,
            'message'   => 'Registration successful',
            'data'      => $user
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
