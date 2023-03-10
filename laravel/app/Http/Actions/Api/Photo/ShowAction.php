<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Photo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photo\ShowRequest;
use App\Http\Responders\Api\Photo\ShowResponder;
use App\Models\Photo;
use App\Usecase\Api\Photo\ShowUsecase;
use Symfony\Component\HttpFoundation\Response;

class ShowAction extends Controller
{
    public function __construct(
        private readonly ShowUsecase $usecase,
        private readonly ShowResponder $responder
    ) {}

    public function __invoke(ShowRequest $request, Photo $photo): Response
    {
        return $this->responder->handle($this->usecase->run($photo));
    }
}
