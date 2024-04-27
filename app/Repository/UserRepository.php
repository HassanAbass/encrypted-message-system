<?php

namespace App\Repository;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;

class UserRepository
{
    public function getUserByEmail(string $email): User
    {
        return User::query()->where('email', $email)->first();
    }

    public function createUserToken(string $email): string
    {
        $user = $this->getUserByEmail($email);
        return $user->createToken('token')->accessToken;
    }

    public function store(RegisterUserRequest $request): void
    {
        User::query()->create($request->all());
    }
}
