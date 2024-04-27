<?php

namespace App\Services;

use App\Jobs\DeleteExpiredMessagesJob;
use App\Models\Message;
use App\Repository\MessageRepository;
use App\Http\Requests\CreateMessageRequest;
use App\Utilities\Constants\GeneralConstant;

readonly class MessageService
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }


    public function createMessage(CreateMessageRequest $request): Message
    {
        $request->merge(["text" => $this->encryptText($request->text, $request->encryption_key)]);

        $message = $this->messageRepository->store($request);

        if ($message->expiry_at) {
            dispatch(new DeleteExpiredMessagesJob($message->id))->delay($message->expiry_at);
        }

        return $message;
    }

    public function getMessage(string $messageId, string $key): false|string
    {
        $message = $this->messageRepository->findById($messageId);

        $decryptedMessage = $this->decryptText($message->text, $key);

        if ($message->read_once) {
            $this->deleteMessage($messageId);
        }

        return $decryptedMessage;
    }

    private function encryptText(string $message, string $key): false|string
    {
        return openssl_encrypt($message, GeneralConstant::CIPHER_ALGO, $key, 0, GeneralConstant::CIPHER_IV);
    }

    private function decryptText(string $message, string $key): false|string
    {
        return openssl_decrypt($message, GeneralConstant::CIPHER_ALGO, $key, 0, GeneralConstant::CIPHER_IV);
    }

    public function deleteMessage(string $messageId): void
    {
        $this->messageRepository->delete($messageId);
    }

}
