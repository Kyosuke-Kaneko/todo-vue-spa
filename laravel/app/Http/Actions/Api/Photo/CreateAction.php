<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Photo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photo\CreateRequest;
use App\Http\Responders\Api\Photo\CreateResponder;
use App\Usecase\Api\Photo\CreateUsecase;
use Symfony\Component\HttpFoundation\Response;

class CreateAction extends Controller
{
    public function __construct(
        private readonly CreateUsecase $usecase,
        private readonly CreateResponder $responder
    ) {}

    public function __invoke(CreateRequest $request): Response
    {
        return $this->responder->handle($this->usecase->run($request));
    }
}
