<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\SignupUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(SignupUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'password' => bcrypt($data['password'])
        ]);

        /** @var User */

        $token = $user->createToken('main')->plainTextToken;

        return response([
            "token" => $token,
            "user" => $user
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt(($credentials))) {
            return response([
                "message" => "Invalid email or password"
            ], 422);
        }

        /** @var User */

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            "token" => $token,
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response("", 204);
    }
}
