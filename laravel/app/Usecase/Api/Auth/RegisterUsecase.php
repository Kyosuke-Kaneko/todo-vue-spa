<?php

namespace App\Usecase\Api\Auth;

use App\Http\Payload;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

readonly class RegisterUsecase
{
    public function __construct(private ConnectionInterface $connection) {}

    public function run(RegisterRequest $request): Payload
    {
        try {
            $this->connection->beginTransaction();

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $this->connection->commit();
        } catch (\Exception $e) {
            \Log::debug($e);
            $this->connection->rollBack();

            return (new Payload())
                ->setStatus(Payload::FAILED);
        }

        Auth::guard()->login($user);

        return (new Payload())
            ->setStatus(Payload::SUCCEED);
    }
}
