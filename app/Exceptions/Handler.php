<?php

namespace App\Exceptions;

use Throwable;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        UnauthorizedException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {

    }

    public function render($request, Throwable $err)
    {

        if($err instanceof ModelNotFoundException || $err instanceof NotFoundHttpException) {
            return $this->errorResponse( __('response.error.not_found'), Response::HTTP_NOT_FOUND,);
        }

        if($err instanceof AuthorizationException) {
            return $this->errorResponse( __('response.error.unauthorized'), Response::HTTP_UNAUTHORIZED,);
        }

        if($err instanceof ValidationException) {
            return response()->json(
                [
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'status' => 'failed',
                    'message' => $err->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if($err instanceof UnauthorizedException) {
            return $this->errorResponse( __('response.error.forbidden'), Response::HTTP_FORBIDDEN,);
        }

        return parent::render($request, $err);
    }

    private function errorResponse($message, $code)
    {
        return response()->json(
            [
                'code' => $code,
                'status' => 'failed',
                'message' => $message,
            ],
            $code
        );
    }
}
