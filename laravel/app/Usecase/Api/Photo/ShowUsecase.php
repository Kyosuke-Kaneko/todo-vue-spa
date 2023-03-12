<?php

declare(strict_types=1);

namespace App\Usecase\Api\Photo;

use App\Http\Payload;
use App\Models\Photo;

readonly class ShowUsecase
{
    public function run(Photo $photo): Payload
    {
        $photo = $photo->with(['owner', 'comments.author'])->first();

        if ($photo) {
            return (new Payload())
                ->setOutput($photo)
                ->setStatus(Payload::SUCCEED);
        } else {
            return (new Payload())
                ->setStatus(Payload::NOT_FOUND);
        }
    }
}
