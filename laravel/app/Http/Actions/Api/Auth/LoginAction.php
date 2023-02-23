<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Responders\Api\Auth\LoginResponder;
use App\Usecase\Api\Auth\LoginUsecase;
use Symfony\Component\HttpFoundation\Response;

class LoginAction extends Controller
{
    public function __construct(
        private readonly LoginUsecase $usecase,
        private readonly LoginResponder $responder
    ) {}

    public function __invoke(LoginRequest $request): Response
    {
        return $this->responder->handle($this->usecase->run($request));
    }
}
