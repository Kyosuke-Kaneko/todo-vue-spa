<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LogoutApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
    public function should_logout()
    {
        $response = $this->actingAs($this->user)
            ->json(Request::METHOD_POST, route('logout'));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertGuest();
    }
}
