<?php

namespace App\Repository;

use App\Models\Message;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;

class MessageRepository
{
    public function create(string $email): string
    {
        $user = Message::query()->where('email', $email)->first();
        return $user->createToken('token')->accessToken;
    }

    public function store(RegisterUserRequest $request): void
    {
        Message::query()->create($request->all());
    }
}
