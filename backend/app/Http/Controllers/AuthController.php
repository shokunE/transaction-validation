<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    private JWTGuard $guard;

    public function __construct(private readonly AuthManager $authManager)
    {
        $this->guard = $this->authManager->guard('api');
    }

    public function login(Request $request): JsonResponse
    {
        if (!$token = $this->guard->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function logout(): JsonResponse
    {
        $this->guard->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $user = $this->guard->user();
        $token = $this->guard->claims($user->getJWTCustomClaims())->refresh();

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard->factory()->getTTL() * 60
        ]);
    }
}
