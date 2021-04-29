<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return $request->store();
    }

    public function login(LoginRequest $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $isLoggedIn = auth()->attempt($request->validated());

        if (!$isLoggedIn) {
            return response([
                'error' => 'Invalid credentials or Account suspended'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = Auth::user()
            ->createToken(auth()->user()->name)->accessToken;

        return response()->json([
            'token' => 'Bearer '. $token,
        ],Response::HTTP_OK);
    }

    public function logout(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        Auth::user()
            ->token()
            ->delete();

        return \response([
            'data' => 'Successfully logout'
        ], Response::HTTP_OK);
    }

    public function verifyEmail(VerifyEmailRequest $request, $user): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = User::findOrFail($user);

        if (is_null($user->code))
        {
            return response([
                'error' => 'email already verified'
            ],Response::HTTP_BAD_REQUEST);
        }

        if ($user->code === $request->code)
        {
            $user->update([
                'code' => null
            ]);

            $user->markEmailAsVerified();

            return \response([
                'data' => 'email verified'
            ],Response::HTTP_OK);
        }

        return \response([
            'error' => 'invalid code'
        ],Response::HTTP_BAD_REQUEST);
    }
}
