<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PhotoListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function should_response_json_data(): void
    {
        Photo::factory(5)->create();

        $response = $this->json(Request::METHOD_GET, route('photo.index'));

        $photos = Photo::with(['owner'])->orderBy('created_at', 'desc')->get();

        $expectedData = $photos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'url' => $photo->url,
                'owner' => [
                    'name' => $photo->owner->name,
                ],
            ];
        })->all();

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonFragment([
            'data' => $expectedData
        ]);
    }
}
