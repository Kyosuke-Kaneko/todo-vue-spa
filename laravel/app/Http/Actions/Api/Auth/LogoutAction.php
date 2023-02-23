<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responders\Api\Auth\LogoutResponder;
use App\Usecase\Api\Auth\LogoutUsecase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoutAction extends Controller
{
    public function __construct(
        private readonly LogoutUsecase $usecase,
        private readonly LogoutResponder $responder
    ) {}

    public function __invoke(Request $request): Response
    {
        return $this->responder->handle($this->usecase->run($request));
    }
}
