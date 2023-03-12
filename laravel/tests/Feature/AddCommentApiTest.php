<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AddCommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function should_add_comments(): void
    {
        Photo::factory()->create();
        $photo = Photo::first();

        $content = 'sample content';

        $response = $this->actingAs($this->user)->json(
            Request::METHOD_POST,
            route('photo.comment', [
                'photo' => $photo->id,
            ]),
            compact('content')
        );

        $comments = $photo->comments()->get();

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment([
            'author' => [
                'name' => $this->user->name,
            ],
            'content' => $content,
        ]);

        // DBに1件登録されているか
        $this->assertEquals(1, $this->count());

        //内容がAPIでリクエストされたものであるか
        $this->assertEquals($content, $comments[0]->content);
    }
}
