<?php

namespace Sakila\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Sakila\Exceptions\Database\NotFoundException;
use Sakila\Exceptions\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{

    /**
     * Exception type to response status code mapper
     *
     * @var array
     */
    protected $statusCodeMap = [
        Response::HTTP_NOT_FOUND => [
            NotFoundException::class,
        ],
        Response::HTTP_BAD_REQUEST => [
            ValidationException::class,
        ]
    ];

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     * @throws \Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return Response
     */
    public function render($request, Exception $e)
    {
        $statusCode = $this->getStatusCode($e);
        $body       = [
            'error' => [
                'code'    => $statusCode,
                'message' => $e->getMessage(),
            ],
        ];

        return new JsonResponse($body, $statusCode);
    }

    /**
     * @param \Exception $exception
     *
     * @return int
     */
    private function getStatusCode(Exception $exception): int
    {
        $exceptionClass = get_class($exception);
        foreach ($this->statusCodeMap as $code => $exceptions) {
            if (in_array($exceptionClass, $exceptions)) {
                return $code;
            }
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
