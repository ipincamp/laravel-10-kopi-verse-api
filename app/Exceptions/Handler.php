<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, \Throwable $exception)
    {
        // Tangani error validasi
        if ($exception instanceof ValidationException) {
            return ApiResponse::send(
                422,
                'Validation error',
                [],
                $exception->validator->errors()->first(),
            );
        }

        // error unauthorized
        if ($exception instanceof AuthenticationException) {
            return ApiResponse::send(
                401,
                'Unauthorized',
                [],
                $exception->getMessage(),
            );
        }

        // error not found
        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::send(
                404,
                'Resource not found',
                [],
                $exception->getMessage(),
            );
        }

        return ApiResponse::send(
            500,
            'An error occurred',
            [],
            $exception->getMessage(),
        );
    }
}
