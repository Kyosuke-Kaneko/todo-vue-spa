<?php

declare(strict_types=1);

namespace App\Usecase\Api\Photo;

use App\Http\Payload;
use App\Http\Requests\Api\Photo\IndexRequest;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;

readonly class IndexUsecase
{
    public function run(): Payload
    {
        $photo = Photo::with(['owner'])
            ->orderBy(Model::CREATED_AT, 'desc')
            ->paginate();

        return (new Payload())
            ->setOutput($photo)
            ->setStatus(Payload::SUCCEED);
    }
}
