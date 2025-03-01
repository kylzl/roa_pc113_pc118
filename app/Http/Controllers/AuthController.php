<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = auth()->User();  
        if ($user) {
            $user->tokens()->delete();
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'You are logged in!',
            'role' => Auth::user()->role
        ]);
        // if (Auth::user() && Auth::user()->role === 'employee') {
        //     return 'Employee login Successfully!';
            

        }
        


    public function logout()
    {
        if (Auth::check()) {
            Auth::User()->tokens()->delete();
        }
        
        return response()->json(['message' => 'Logged out']);
    }
}