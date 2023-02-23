<?php

declare(strict_types=1);

namespace App\Http\Responders\Api;

use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiResponder
{
    public function __construct(protected ResponseFactory $responseFactory) {}

    protected function notFoundResponse(): JsonResponse
    {
        return $this->responseFactory->json([
            'errors' => [
                'code' => 'DATA_NOT_FOUND',
                'messages' => '対象のデータが存在しません。'
            ],
        ], Response::HTTP_NOT_FOUND);
    }

    protected function systemErrorResponse(): JsonResponse
    {
        return $this->responseFactory->json([
            'errors' => [
                'code' => 'SYSTEM_ERROR',
                'messages' => 'システムエラーが発生しました。'
            ],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function successResponse(): JsonResponse
    {
        return $this->responseFactory->json([
            'code' => Response::HTTP_OK,
            'message' => '処理成功'
        ]);
    }
}
