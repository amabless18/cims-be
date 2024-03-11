<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST: api/auth/login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('authToken')->plainTextToken;
            return response()->json(['authToken' => $token]); // Updated response structure
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    // POST: api/auth
    public function createUser(Request $request)
    {
        $user = User::create([
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'course' => $request->input('course'),
            'branch' => $request->input('branch'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json($user, 201);
    }

    // POST: api/auth/forgot-password
    public function forgotPassword(Request $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['status' => __($status)])
                    : response()->json(['status' => __($status)], 400);
    }

    // GET: api/auth/me
    public function getUserByToken(Request $request)
    {
        return response()->json($request->user());
    }
}
