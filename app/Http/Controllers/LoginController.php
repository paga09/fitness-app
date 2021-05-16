<?php

namespace App\Http\Controllers;

//use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
//        $request->validate([
//            'email' => ['required', 'email'],
//            'password' => ['required'],
//        ]);
//
//        if (Auth::attempt($request->only('email', 'password'))) {
//            return response()->json(Auth::user(), 200);
//        }
//        throw ValidationException::withMessages([
//            'email' => ['Incorrect credentials.'],
//            'password' => ['Incorrect credentials.'],
//        ]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
//        $token = $request->user()->createToken($request->token_name);
        return $user->createToken($request->device_name)->plainTextToken;
//        return ['token' => $token->plainTextToken];

    }

    public function logout()
    {
        Auth::logout();
    }
}
