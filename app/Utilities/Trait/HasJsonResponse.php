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

	public function errorResponse(string $message, \Throwable $exception = null, int $code = Response::HTTP_BAD_REQUEST, mixed $errors = null): JsonResponse
	{
		$exceptionMessage = $exception?->getMessage();
		$responseData = collect([
			"message" => $message,
			"errors" => $errors ?? $exceptionMessage
		]);
		$responseJson = new JsonResponse($responseData, $code);
		if ($exceptionMessage === $message || (!$exceptionMessage) && !$errors) {
			$responseJson->setData($responseData->except(['errors']));
		}
		return $responseJson;
	}
}
