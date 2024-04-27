<?php

namespace App\Utilities\Trait;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HasJsonResponse
{
	/**
	 * @param string $message
	 * @param mixed|null $data
	 * @param int $code
	 * @return JsonResponse
	 */
	public function jsonResponse(string $message, mixed $data = null, int $code = Response::HTTP_OK): JsonResponse
	{
		return response()->json([
			"message" => $message,
			"data" => $data
		], $code);
	}
}
