<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(6)->uncompromised()]
        ];
    }

    public function store(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'code' => Str::random(5)
        ]);

        $user->notify(new VerifyEmailNotification($user));

        return response([
            'data' => 'Registration successful & Verification email sent',
            'user' => $user->id,
        ],Response::HTTP_CREATED);
    }
}
