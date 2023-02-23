<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function should_created_user(): void
    {
        $data = [
            'name' => 'vuesplash user',
            'email' => 'dummy@email.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ];

        $response = $this->json(
            Request::METHOD_POST,
            route('register'),
            $data
        );

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertEquals($data['name'], User::first()->name);
    }
}
