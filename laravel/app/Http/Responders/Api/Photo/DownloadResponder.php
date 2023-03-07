<?php

declare(strict_types=1);

namespace App\Http\Responders\Api\Photo;

use App\Exceptions\UndefinedStatusException;
use App\Http\Payload;
use App\Http\Responders\Api\ApiResponder;
use Symfony\Component\HttpFoundation\Response;

class DownloadResponder extends ApiResponder
{
    public function handle(Payload $payload): Response
    {
        if ($payload->getStatus() === Payload::SUCCEED) {
            return $this->responseFactory->make(
                $payload->getOutput(),
                Response::HTTP_OK, [
                    'Content-Type' => finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $payload->getOutput()['content']),
                    'Content-Disposition' => "attachment; filename={$payload->getOutput()['filename']}",
                ],
            );
        }

        throw UndefinedStatusException::fromStatus($payload->getStatus());
    }
}
