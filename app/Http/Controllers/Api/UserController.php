<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Str::random(60);

            $request->user()->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();

            return $request->user();
        } else {
            return response(['message' => 'User not found'], 404);
        }
    }

    public function show(Request $request)
    {
        return response(Auth::user(), 200);
    }
}
