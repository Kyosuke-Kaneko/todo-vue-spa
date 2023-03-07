<?php

declare(strict_types=1);

namespace App\Http\Actions\Api\Photo;

use App\Http\Controllers\Controller;
use App\Http\Responders\Api\Photo\DownloadResponder;
use App\Models\Photo;
use App\Usecase\Api\Photo\DownloadUsecase;
use Symfony\Component\HttpFoundation\Response;

class DownloadAction extends Controller
{
    public function __construct(
        private readonly DownloadUsecase $usecase,
        private readonly DownloadResponder $responder
    ) {}

    public function __invoke(Photo $photo): Response
    {
        return $this->responder->handle($this->usecase->run($photo));
    }
}
