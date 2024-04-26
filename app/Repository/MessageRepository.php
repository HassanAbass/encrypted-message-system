<?php

namespace App\Repository;

use App\Http\Requests\CreateMessageRequest;
use App\Models\Message;

class MessageRepository
{

    public function store(CreateMessageRequest $request): Message
    {
        return Message::query()->create($request->all());
    }

    public function findById(string $uuid): Message
    {
        return Message::query()->find($uuid);
    }

    public function delete(string $uuid): void
    {
        Message::query()->where('id', $uuid)->delete();
    }
}
