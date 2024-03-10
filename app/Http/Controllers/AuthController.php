<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        $res = $this->authService->login($request);

        if (!count($res)) {
            return response()->json(User::AUTH_FAILED, 404);
        }

        return response()->json($res, 200);
    }

    public function register(RegistrationRequest $request)
    {
        $res = $this->authService->register($request);

        if (!count($res)) {
            return response()->json(User::REGISTRATION_FAILED, 500);
        }

        return response()->json($res, 200);
    }

    public function logout(Request $request)
    {
        $res = $this->authService->logout();

        if (!$res) {
            return response()->json(User::LOGOUT_FAILED, 500);
        }

        return response()->json(User::LOGOUT_SUCCESSFUL, 204);
    }
}
