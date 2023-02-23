<?php

namespace App\Http\Responders\Api\Auth;

use App\Exceptions\UndefinedStatusException;
use App\Http\Payload;
use App\Http\Responders\Api\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponder extends ApiResponder
{
    public function handle(Payload $payload): Response
    {
        if ($payload->getStatus() === Payload::SUCCEED) {
            return $this->responseFactory->json(
                status: Response::HTTP_CREATED
            );
        }

        if ($payload->getStatus() === Payload::FAILED) {
            return $this->systemErrorResponse();
        }

        throw UndefinedStatusException::fromStatus($payload->getStatus());
    }
}
