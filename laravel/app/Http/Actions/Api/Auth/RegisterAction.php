<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Responders\Api\Auth\RegisterResponder;
use App\Usecase\Api\Auth\RegisterUsecase;
use Symfony\Component\HttpFoundation\Response;

class RegisterAction extends Controller
{
    public function __construct(
        private readonly RegisterUsecase $usecase,
        private readonly RegisterResponder $responder
    ) {}

    public function __invoke(RegisterRequest $request): Response
    {
        return $this->responder->handle($this->usecase->run($request));
    }
}
