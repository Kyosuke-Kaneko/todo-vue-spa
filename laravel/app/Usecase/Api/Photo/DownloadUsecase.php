<?php

declare(strict_types=1);

namespace App\Usecase\Api\Photo;

use App\Http\Payload;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

readonly class DownloadUsecase
{
    public function run(Photo $photo): Payload
    {
        abort_if(! Storage::cloud()->exists($photo->filename), Response::HTTP_NOT_FOUND);

        $content = Storage::cloud()->get($photo->filename);
        $filename = $photo->filename;

        return (new Payload())
            ->setOutput(compact('content', $filename))
            ->setStatus(Payload::SUCCEED);
    }
}
