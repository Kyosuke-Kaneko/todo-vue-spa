<?php

declare(strict_types=1);

namespace App\Http\Responders\Api\Photo;

use App\Exceptions\UndefinedStatusException;
use App\Http\Payload;
use App\Http\Responders\Api\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class ShowResponder extends ApiResponder
{
    public function handle(Payload $payload): Response
    {
        \Log::debug($payload->getOutput());
        if ($payload->getStatus() === Payload::SUCCEED) {
            return $this->responseFactory->json(
                data: $payload->getOutput(),
                status: Response::HTTP_OK,
            );
        }

        if ($payload->getStatus() === Payload::NOT_FOUND) {
            return $this->responseFactory->json(
                status: Response::HTTP_NOT_FOUND,
            );
        }

        throw UndefinedStatusException::fromStatus($payload->getStatus());
    }
}
