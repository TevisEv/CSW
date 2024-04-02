<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

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
            if ($e instanceof ValidationException) {
                //Log::info('From renderable method: ' . $e->getMessage());

                // you can return a view, json object, e.t.c
                return response()->json([
                    'message' => 'From renderable method: Resource not found'
                ], Response::HTTP_NOT_FOUND);
            }
        });
    }
}