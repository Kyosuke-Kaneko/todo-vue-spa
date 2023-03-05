<?php

declare(strict_types=1);

namespace App\Usecase\Api\Photo;

use App\Http\Payload;
use App\Http\Requests\Api\Photo\CreateRequest;
use App\Models\Photo;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

readonly class CreateUsecase
{
    public function __construct(private ConnectionInterface $connection) {}

    public function run(CreateRequest $request): Payload
    {
        $extension = $request->photo->extension();
        $photoId = (string)Uuid::uuid4();
        $filename = sprintf('%s.%s', $photoId, $extension);

        Storage::cloud()->putFileAs(
            '', $request->photo, $filename, 'public'
        );

        try {
            $this->connection->beginTransaction();

            $photo = Photo::create([
                'id' => $photoId,
                'filename' => $filename,
                'user_id' => Auth::id(),
            ]);

            $this->connection->commit();
        } catch (\Exception $e) {
            \Log::debug($e);

            $this->connection->rollBack();
            Storage::delete($filename);

            return (new Payload())
                ->setStatus(Payload::FAILED);
        }

        return (new Payload())
            ->setOutput($photo)
            ->setStatus(Payload::SUCCEED);
    }
}
