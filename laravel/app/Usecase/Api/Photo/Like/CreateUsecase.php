<?php

declare(strict_types=1);

namespace App\Usecase\Api\Photo\Like;

use App\Http\Payload;
use App\Models\Photo;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\Auth;

readonly class CreateUsecase
{
    public function __construct(private ConnectionInterface $connection) {}

    public function run(Photo $photo): Payload
    {
        $photo->with('likes')->first();

        try {
            $this->connection->beginTransaction();

            $photo->likes()->detach(Auth::id());
            $photo->likes()->attach(Auth::id());

            $this->connection->commit();
        } catch (\Exception $e) {
            \Log::debug($e);

            $this->connection->rollBack();

            return (new Payload())
                ->setStatus(Payload::FAILED);
        }

        return (new Payload())
            ->setOutput(['photo_id' => $photo->id])
            ->setStatus(Payload::SUCCEED);
    }
}
