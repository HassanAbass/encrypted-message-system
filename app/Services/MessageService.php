<?php

namespace App\Services;

use App\Http\Requests\ReadMessageRequest;
use App\Models\Message;
use App\Repository\MessageRepository;
use App\Http\Requests\CreateMessageRequest;
use App\Utilities\Constants\GeneralConstants;
use Illuminate\Support\Facades\Crypt;

readonly class MessageService
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }


    public function createMessage(CreateMessageRequest $request): Message
    {
        $request->merge(["text" => $this->encryptText($request->text, $request->encryption_key)]);
        return $this->messageRepository->store($request);
    }

    public function getMessage(string $messageId, string $key): false|string
    {
        $message = $this->messageRepository->findById($messageId);

        $decryptedMessage = $this->decryptText($message->text, $key);
       // dd($decryptedMessage);
//        if($message->read_once) {
//            $this->messageRepository->delete($messageId);
//        }
//        dd($decryptedMessage);

        return $decryptedMessage;
    }

    private function encryptText(string $message, string $key): false|string
    {

        return  openssl_encrypt($message, GeneralConstants::CIPHER_ALGO, $key, 0, '1234156782191011');
    }

    private function decryptText(string $message, string $key): false|string
    {
        $iv_length = openssl_cipher_iv_length(GeneralConstants::CIPHER_ALGO);
        $iv = openssl_random_pseudo_bytes($iv_length);
//        dd($iv);
        return openssl_decrypt($message, GeneralConstants::CIPHER_ALGO, $key, 0, '1234156782191011');
    }

}
