<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PhotoSubmitApiTest extends TestCase
{
    use RefreshDatabase;

    // php artisan test --filter PhotoSubmitApiTest

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function should_upload_photo(): void
    {
        Storage::fake('s3');

        $response = $this->actingAs($this->user)
            ->json(
                Request::METHOD_POST,
                route('photo.create'), [
                    // ダミーファイルを作成して送信
                    'photo' => UploadedFile::fake()->image('photo.jpg')
            ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $photo = Photo::first();

        $this->assertMatchesRegularExpression(
            '/([0-9a-f]{8})-([0-9a-f]{4})-(4[0-9a-f]{3})-([0-9a-f]{4})-([0-9a-f]{12})/',
            $photo->id
        );

        Storage::cloud()->assertExists($photo->filename);
        Storage::cloud()->delete($photo->filename);
    }

    /**
     * @test
     * @return void
     */
    public function should_db_error(): void
    {
        // DBエラーを発生させる
        Schema::drop('photos');

        Storage::fake('s3');

        $response = $this->actingAs($this->user)
            ->json(
                Request::METHOD_POST,
                route('photo.create'), [
                    'photo' => UploadedFile::fake()->image('photo.jpg')
                ]
            );

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

        // ストレージにファイルが保存されていない
        $this->assertCount(0, Storage::cloud()->files());
    }

    /**
     * @test
     * @return void
     */
    public function should_file_error(): void
    {
        Storage::shouldReceive('cloud')
            ->once()
            ->andReturnNull();

        $response = $this->actingAs($this->user)
            ->json(
                Request::METHOD_POST,
                route('photo.create'), [
                    'photo' => UploadedFile::fake()->image('photo.jpg')
                ]
            );

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

        $this->assertEmpty(Photo::all());
    }
}
