<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responders\Api\Auth\TokenResponder;
use App\Usecase\Api\Auth\TokenUsecase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAction extends Controller
{
    public function __construct(
        private readonly TokenUsecase $usecase,
        private readonly TokenResponder $responder
    ) {}

    public function __invoke(Request $request): Response
    {
        return $this->responder->handle($this->usecase->run($request));
    }
}
