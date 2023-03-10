<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PhotoDetailApiTest extends TestCase
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
        Photo::factory(1)->create();
        $photo = Photo::first();

        $response = $this->json(
            Request::METHOD_GET,
            route('photo.show', [
                'photo' => $photo->id,
            ]));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'id' => $photo->id,
            'url' => $photo->url,
            'owner' => [
                'name' => $photo->owner->name,
            ],
        ]);
    }
}
