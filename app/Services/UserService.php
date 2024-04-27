<?php

namespace App\Services;

use App\Http\Requests\RegisterUserRequest;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function authenticate(string $email, string $password): bool
    {
        if ($user = $this->userRepository->getUserByEmail($email)) {
            return Hash::check($password, $user->password);
        }

        return false;
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
