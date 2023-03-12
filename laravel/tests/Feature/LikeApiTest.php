<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Photo::factory()->create();
        $this->photo = Photo::first();
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function should_add_like(): void
    {
        $response = $this->actingAs($this->user)
            ->json(
                Request::METHOD_PUT,
                route('photo.like', [
                    'photo' => $this->photo->id,
                ])
            );

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment([
            'photo_id' => $this->photo->id,
        ]);

        $this->assertEquals(1, $this->photo->likes()->count());
    }

    /**
     * @test
     * @return void
     */
    public function should_1_like(): void
    {
        $param = [
            'photo' => $this->photo->id
        ];

        $this->actingAs($this->user)
            ->json(
                Request::METHOD_PUT,
                route('photo.like', $param)
            );

        $this->actingAs($this->user)
            ->json(
                Request::METHOD_PUT,
                route('photo.like', $param)
            );

        $this->assertEquals(1, $this->photo->likes()->count());
    }

    /**
     * @test
     * @return void
     */
    public function should_remove_like(): void
    {
        $this->photo->likes()->attach($this->user->id);

        $response = $this->actingAs($this->user)
            ->json(
                Request::METHOD_DELETE,
                route('photo.like', [
                    'photo' => $this->photo->id,
                ])
            );

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'photo_id' => $this->photo->id,
            ]);

        $this->assertEquals(0, $this->photo->likes()->count());
    }
}
