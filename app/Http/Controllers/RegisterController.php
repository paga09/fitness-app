<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'settings' => '{"protein":true,"carbs":true,"fat":true,"fiber":true,"kcal":true}'
        ]);

        return response()->json([
            'msg' => 'Registered successfully'
        ]);

    }
}
