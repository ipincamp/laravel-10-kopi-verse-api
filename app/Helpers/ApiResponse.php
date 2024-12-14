<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Generate a response.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $data
     * @param mixed $errors
     * @return JsonResponse
     */
    public static function send(
        int $statusCode = 200,
        string $message = null,
        $data = null,
        $errors = null,
    ): JsonResponse {
        return response()->json([
            'success' => $statusCode < 400,
            'message' => $message ?? ($statusCode < 400 ? $message : 'An error occurred'),
            'data' => $statusCode < 400 ? $data : [],
            'errors' => $statusCode >= 400 ? $errors : null,
        ], $statusCode);
    }
}
