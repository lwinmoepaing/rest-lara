<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

// !Report Excepitions
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


// Use Api Helper Trait
use App\Traits\ApiResponser;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException) {
            return  $this->convertValidationExceptionToResponse($exception, $request);
        }

        if($exception instanceof ModelNotFoundException) {
            $modelName = class_basename($exception->getModel());
            return  $this->errorResponse("Does not exist any {$modelName} with the specific identifier.", 404);
        }

        if($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        if($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('This route cannot be found.', 404);
        }

        if($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('Request method is Invalid.', 405);
        }

        if($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessages(), $exception->getStatusCode());
        }

        if($exception instanceof QueryException) {
            return $this->queryExceptionHandler($exception, $request);
        }

        // Debuging Mode to Unexpected Error
        if(config('app.debug')) {
            // Default Parent Render Method
            return parent::render($request, $exception);
        }

        // Handling Unexpected Error
        // Response Json
        return $this->errorResponse(
            'Unexpected Error Try Again Later.', 500
        );
    }

    /*
    |---------------------------------------
    | Authentication exception To Json response.
    |---------------------------------------
    */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->errorResponse('Unauthenticate!!', 401);
    }

    /*
    |---------------------------------------
    | Validatation Error To Json Response
    |---------------------------------------
    */
    public function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }

    /*
    |---------------------------------------
    | Query Error To Json Response
    |---------------------------------------
    */
    public function queryExceptionHandler(QueryException $exception, $request)
    {
        // There is code inside ErrorInfo Array Index 1
        $errorCode = $exception->errorInfo[1];

        if($errorCode == 1451) {
            return $this->errorResponse('Cannot Remove permanently. It related another field.', 409);
        }

        $error = "Some query error Or Connectons";
        return $this->errorResponse($error, 500);
    }
}
