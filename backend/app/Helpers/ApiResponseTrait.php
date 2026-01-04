<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected function success(mixed $data = null, string|array $message = [''], int $code = 200): JsonResponse
    {
        if (is_string($message)) {
            $message = [$message];
        }
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message
        ], $code);
    }

    protected function error(string|array $message = ['Internal Server Error'], int $code = 500): JsonResponse
    {
        if (is_string($message)) {
            $message = [$message];
        }

        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}
