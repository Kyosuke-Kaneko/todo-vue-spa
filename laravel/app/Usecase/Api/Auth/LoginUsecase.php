<?php

namespace App\Usecase\Api\Auth;

use App\Http\Payload;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginUsecase
{
    public function run(LoginRequest $request): Payload
    {
        $userData = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($userData)) {
            $request->session()->regenerate();

            return (new Payload())
                ->setStatus(Payload::SUCCEED);
        }

        return (new Payload())
            ->setStatus(Payload::FAILED);
    }
}
