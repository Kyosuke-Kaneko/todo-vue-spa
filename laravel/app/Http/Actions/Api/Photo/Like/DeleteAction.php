<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Photo\Like;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photo\Like\DeleteRequest;
use App\Http\Responders\Api\Photo\Like\DeleteResponder;
use App\Models\Photo;
use App\Usecase\Api\Photo\Like\DeleteUsecase;
use Symfony\Component\HttpFoundation\Response;

class DeleteAction extends Controller
{
    public function __construct(
        private readonly DeleteUsecase $usecase,
        private readonly DeleteResponder $responder
    ) {}

    public function __invoke(Photo $photo, DeleteRequest $request): Response
    {
        return $this->responder->handle($this->usecase->run($photo));
    }
}
