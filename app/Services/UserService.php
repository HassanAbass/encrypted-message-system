<?php

namespace App\Services;

use App\Http\Requests\RegisterUserRequest;
use App\Repository\UserRepository;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getToken(string $email): string
    {
        return $this->userRepository->createUserToken($email);
    }

    public function createUser(RegisterUserRequest $request): void
    {
        $this->userRepository->store($request);
    }


}
