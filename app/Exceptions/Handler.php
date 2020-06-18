<?php

namespace App\Exceptions;

use App\Http\Controllers\Admin\Controller;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception) || $exception instanceof ModelNotFoundException) {
            if ($exception instanceof ModelNotFoundException || $exception->getStatusCode() == 404) {
                if (Auth::check()) {
                    $domain = Str::of($request->getHost());
                    if (/*Auth::getUser()->is_admin && todo*/ $domain->contains('admin')) {
                        $controller = new Controller();
                        $controller->meta->prependTitle('404');
                        return response()->view('errors.404', [], 404);
                    }
                }
                return response()->view('frontend.errors.404', [], 404);
            }
        }

        if ($request->ajax()) {
            if ($exception instanceof ValidationException)
                return response()->json([
                    'message' => 'Помилково заповнені поля',
                    'errors' => $exception->validator->getMessageBag()
                ], 422);
        }

        return parent::render($request, $exception);
    }
}
