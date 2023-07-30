<?php
namespace App\Exceptions;

use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Exceptions\Role\CantDeleteRoleWithRelationsException;
use App\Exceptions\Token\InvalidTokenException;
use App\Exceptions\UserIdentifier\InvalidVerificationCodeException;
use App\Exceptions\UserIdentifier\UserIdentifierAlreadyVerifiedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * Class Handler
 * @package App\Exceptions
 */
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception) && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
    //    dd(get_class($e), $e->getMessage());

        if($e instanceof ValidationException) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        if($e instanceof OtpExpiredException) {
            return response()->json([
                    'message' => 'otp code expired or not exists',
                    'message_code' => 'invalid_otp_code',
                    'code' => 404
                ], 404);
        }

        if($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Not Found',
                'code' => 404
            ], 404);
        }

        if($e instanceof NotFoundHttpException && str_starts_with($request->getRequestUri(), '/api')) {
            return response()->json([
                'message' => 'Not Found',
                'code' => 404
            ], 404);
        }

        if($e instanceof OneOrMoreRoleWasNotFoundException) {
            return response()->json([
                'message' => 'One or more role not found',
                'code' => 404
            ], 404);
        }

        if($e instanceof CantDeleteRoleWithRelationsException) {
            return response()->json([
                'message' => "You can't delete logged in user",
                'code' => 400
            ], 400);
        }

        if($e instanceof InvalidUserCredentialsException) {
            return response()->json([
                'message' => 'Invalid Credentials',
                'code' => 401
            ], 401);
        }

        if($e instanceof UserRoleRelationAlreadyExistsException) {
            return response()->json([
                'message' => 'one or more user-role relation already exists',
                'code' => 400
            ], 400);
        }

        if($e instanceof RoleScopeRelationAlreadyExistsException) {
            return response()->json([
                'message' => 'one or more role-scope relation already exists',
                'code' => 400
            ], 400);
        }


        if($e instanceof InvalidTokenException) {
            return response()->json([
                'message' => 'Invalid Token',
                'code' => 401
            ], 401);
        }

        if($e instanceof UserIdentifierAlreadyVerifiedException) {
            return response()->json([
                'message' => 'Already Verified',
                'code' => 422
            ], 422);
        }

        if($e instanceof InvalidVerificationCodeException) {
            return response()->json([
                'message' => 'Invalid Verification Code',
                'code' => 422
            ], 422);
        }

        return parent::render($request, $e);
    }
}
