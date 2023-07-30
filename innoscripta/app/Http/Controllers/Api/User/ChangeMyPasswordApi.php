<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\ChangeMyPasswordAction;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Lib\TokenInfoVO;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Entities\UserEntity;

/**
 * Class ChangeMyPasswordApi
 * @package App\Http\Controllers\Api\User
 */
class ChangeMyPasswordApi
{

    /**
     * @var ChangeMyPasswordAction
     */
    private ChangeMyPasswordAction $changeMyPasswordAction;

    /**
     * @var UserValidator
     */
    private UserValidator $userValidator;

    /**
     * ChangeMyPasswordApi constructor.
     * @param ChangeMyPasswordAction $changeMyPasswordAction
     * @param UserValidator $userValidator
     */
    public function __construct(ChangeMyPasswordAction $changeMyPasswordAction, UserValidator $userValidator)
    {
        $this->changeMyPasswordAction = $changeMyPasswordAction;
        $this->userValidator = $userValidator;
    }

    /**
     * @throws ValidationException
     * @throws InvalidUserCredentialsException
     */
    public function __invoke(): JsonResponse
    {
        $oldPassword = request('old_password');
        $newPassword = request('new_password');

        $this->userValidator->changePasswordValidator(request()->only('old_password', 'new_password'));

        $tokenInfo = request('tokenInfo');
        $userEntity = $tokenInfo['userEntity'] ?? null;
        $userEntity = UserEntity::createFromTokenInfo($userEntity);

        $this->changeMyPasswordAction->__invoke($userEntity, $oldPassword, $newPassword);

        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }

}
