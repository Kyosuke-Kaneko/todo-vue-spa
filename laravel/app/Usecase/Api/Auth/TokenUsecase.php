<?php

declare(strict_types=1);

namespace App\Usecase\Api\Auth;

use App\Http\Payload;
use Illuminate\Http\Request;

class TokenUsecase
{
    public function run(Request $request): Payload
    {
        $request->session()->regenerateToken();

        return (new Payload())
            ->setStatus(Payload::SUCCEED);
    }
}
