<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService 
{
    public function login($request)
    {
        try {
            $user = User::email(request('email'))->first();

            if ($user) {
                if (Auth::attempt($request->only('email', 'password'))) {
                    $token = $user->createToken('authToken')->plainTextToken;

                    return [
                        'token' => $token,
                        'user' => $user,
                    ];
                }
            }
        } catch (\Throwable $th) {
            info($th->getMessage());
        }

        return [];
    }

    public function register($request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return [
                'token' => $token,
                'user' => $user
            ];
        } catch (\Throwable $th) {
            info($th->getMessage());
        }

        return [];
    }

    public function logout()
    {
        try {
            $user = request()->user();
            $user->tokens()->delete();
        } catch (\Throwable $th) {
            info($th->getMessage());
            return false;
        }

        return true;
    }
}