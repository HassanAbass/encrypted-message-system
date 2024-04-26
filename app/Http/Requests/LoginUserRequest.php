<?php

namespace App\Http\Requests;

use App\Enums\User\UserStatus;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'email' => 'required|email',
			'password' => 'string|required|min:6'
		];
	}
}
