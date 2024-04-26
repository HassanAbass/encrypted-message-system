<?php

namespace App\Http\Requests;

use App\Enums\User\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string',
            'encryption_key' => 'required|string',
            'recipient_id' => 'string|required|exists:users,id',
            'read_once' => 'nullable|boolean',
            'expiry_at' => 'nullable|date',
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'id' => Str::orderedUuid(),
            'user_id' => auth()->user()->getAuthIdentifier(),
        ]);
    }
}
