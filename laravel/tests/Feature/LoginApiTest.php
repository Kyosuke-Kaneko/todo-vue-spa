<?php

namespace Tests\Feature;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginApiTest extends TestCase
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
    public function should_login()
    {
        $response = $this->json(Request::METHOD_POST, route('login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertAuthenticatedAs($this->user);
    }
}
