<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Photo\Like;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photo\Like\CreateRequest;
use App\Http\Responders\Api\Photo\Like\CreateResponder;
use App\Models\Photo;
use App\Usecase\Api\Photo\Like\CreateUsecase;
use Symfony\Component\HttpFoundation\Response;

class CreateAction extends Controller
{
    public function __construct(
        private readonly CreateUsecase $usecase,
        private readonly CreateResponder $responder
    ) {}

    public function __invoke(Photo $photo, CreateRequest $request): Response
    {
        return $this->responder->handle($this->usecase->run($photo));
    }
}
