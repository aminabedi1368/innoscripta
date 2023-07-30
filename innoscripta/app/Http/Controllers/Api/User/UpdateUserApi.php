<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\UpdateUserAction;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\UserHydrator;
use App\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class UpdateUserApi
 * @package App\Http\Controllers\Api\User
 */
class UpdateUserApi
{
    /**
     * @var UpdateUserAction
     */
    private UpdateUserAction $updateUserAction;

    /**
     * @var UserValidator
     */
    private UserValidator $userValidator;

    /**
     * @var UserHydrator
     */
    private UserHydrator $userHydrator;

    /**
     * UpdateUserApi constructor.
     * @param UpdateUserAction $updateUserAction
     * @param UserValidator $userValidator
     * @param UserHydrator $userHydrator
     */
    public function __construct(
        UpdateUserAction $updateUserAction,
        UserValidator $userValidator,
        UserHydrator $userHydrator
    )
    {
        $this->updateUserAction = $updateUserAction;
        $this->userValidator = $userValidator;
        $this->userHydrator = $userHydrator;
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     * @throws CorruptedDataException
     */
    public function __invoke(int $id)
    {
        $this->userValidator->validateUpdateUserProfileByHimSelf(request()->only('first_name', 'last_name'));

        $userEntity = $this->updateUserAction->__invoke($id, request('first_name'), request('last_name'));

        return response()->json($this->userHydrator->fromEntity($userEntity)->toArray());
    }

}
