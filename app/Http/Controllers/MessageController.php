<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadMessageRequest;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use App\Utilities\Trait\HasJsonResponse;
use App\Http\Requests\CreateMessageRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Routing\Controllers\HasMiddleware;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller implements HasMiddleware
{
    use HasJsonResponse, HasUuids;

    public function __construct(private readonly MessageService $messageService)
    {

    }

    public static function middleware(): array
    {
        return [
            'auth:api'
        ];
    }

    public function store(CreateMessageRequest $request): JsonResponse
    {
        return $this->jsonResponse(__('messages.success'), $this->messageService->createMessage($request));
    }

    public function getMessage(ReadMessageRequest $request): JsonResponse
    {
        $message = $this->messageService->getMessage($request->message_identifier);

        if (auth()->user()->getAuthIdentifier() !== $message->recipient_id) {
            return $this->jsonResponse(__('messages.unauthorized'), Response::HTTP_UNAUTHORIZED);
        }

        return $this->jsonResponse(__('messages.success'), [
            'text' => $this->messageService->getMessageText($request->message_identifier, $request->encryption_key)
        ]);
    }
}
