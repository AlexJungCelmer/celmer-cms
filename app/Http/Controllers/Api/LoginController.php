<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken(md5(uniqid($user->email, true)))->plainTextToken;
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $user->applications();
        $apps = $user->apps;
        if ($user->tokenCan('*')) {
            $user->can = ['admin' => true];
        } else {
            $user->can = $user->tokens[count($user->tokens) - 1]->abilities;
        }

        if ($user->is_admin == 1) {
            $AllApps = Application::select('id', 'name', 'slug')->get();
        }
        return response()->json([
            'email' => $user->email,
            'name' => $user->name,
            'is_admin' => $user->is_admin,
            'user_apps' => $apps,
            'can' => $user->can,
            'admin_apps' => $AllApps,
        ]);
    }

    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
