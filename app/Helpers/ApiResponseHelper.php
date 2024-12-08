<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper
{
    /**
     * Generate success response.
     *
     * @param string $message
     * @param array|object $data
     * @return JsonResponse
     */
    public static function success(string $message, $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null,
        ], $statusCode);
    }

    /**
     * Generate error response.
     *
     * @param string $message
     * @param array|object|null $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error(string $message, $errors = null, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => [],
            'errors' => $errors,
        ], $statusCode);
    }
}
