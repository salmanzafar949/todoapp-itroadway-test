<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return $request->store();
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
