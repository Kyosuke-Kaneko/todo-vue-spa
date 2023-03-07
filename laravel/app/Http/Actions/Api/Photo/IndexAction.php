<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Photo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photo\IndexRequest;
use App\Http\Responders\Api\Photo\IndexResponder;
use App\Usecase\Api\Photo\IndexUsecase;
use Symfony\Component\HttpFoundation\Response;

class IndexAction extends Controller
{
    public function __construct(
        private readonly IndexUsecase $usecase,
        private readonly IndexResponder $responder
    ) {}

    public function __invoke(IndexRequest $request): Response
    {
        return $this->responder->handle($this->usecase->run());
    }
}
