<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadMessageRequest;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use App\Utilities\Trait\HasJsonResponse;
use App\Http\Requests\CreateMessageRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MessageController extends Controller
{
    use HasJsonResponse, HasUuids;

    public function __construct(private readonly MessageService $messageService)
    {
    }

    public function store(CreateMessageRequest $request): JsonResponse
    {
        return $this->jsonResponse(__('messages.general.success'), $this->messageService->createMessage($request));
    }

    public function getMessage(ReadMessageRequest $request): JsonResponse
    {
//        $this->messageService->getMessage($request);
        return $this->jsonResponse(__('messages.general.success'), [
            'text' => $this->messageService->getMessage($request->message_identifier, $request->encryption_key)
        ]);
    }
}
