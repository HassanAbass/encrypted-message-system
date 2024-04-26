<?php

namespace App\Repository;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;

class UserRepository
{
    public function createUserToken(string $email): string
    {
        $user = User::query()->where('email', $email)->first();
        return $user->createToken('token')->accessToken;
    }

    public function store(RegisterUserRequest $request): void
    {
        User::query()->create($request->all());
    }
}
