<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use App\Utilities\Trait\HasJsonResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginUserRequest;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    use HasJsonResponse;
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->all())) {
            return response()->json(['message' => __('auth.failed')], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($this->userService->getToken($request->email));
    }

    private function respondWithToken(string $token): JsonResponse
    {
        return $this->jsonResponse(__('messages.login.success'), [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_date' => Carbon::now()->addHours(2)
        ]);
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $this->userService->createUser($request);
        return $this->respondWithToken($this->userService->getToken($request->email));
    }
}
