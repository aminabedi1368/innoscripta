<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\ForgetPasswordAction;
use App\Exceptions\OtpExpiredException;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class ForgetPasswordApi
 * @package App\Http\Controllers\Api\User
 */
class ForgetPasswordApi
{

    /**
     * @var ForgetPasswordAction
     */
    private ForgetPasswordAction $forgetPasswordAction;
    /**
     * @var UserValidator
     */
    private UserValidator $userValidator;

    /**
     * ForgetPasswordApi constructor.
     * @param ForgetPasswordAction $forgetPasswordAction
     * @param UserValidator $userValidator
     */
    public function __construct(ForgetPasswordAction $forgetPasswordAction, UserValidator $userValidator)
    {
        $this->forgetPasswordAction = $forgetPasswordAction;
        $this->userValidator = $userValidator;
    }

    /**
     * @return JsonResponse
     * @throws OtpExpiredException
     * @throws ValidationException
     */
    public function __invoke()
    {
        $this->userValidator->forgetPasswordValidator(request()->all('code', 'new_password'));
        $this->forgetPasswordAction->__invoke(request('code'), request('new_password'));

        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }

}
