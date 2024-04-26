<?php

namespace App\Http\Requests;

use App\Enums\User\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ReadMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'message_identifier' => 'required|exists:messages,id',
            'encryption_key' => 'required|string'
        ];
    }
}
