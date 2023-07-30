<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\UserIdentifier\AddUserIdentifierAction;
use App\Actions\UserIdentifier\GetUserIdentifierAction;
use App\Actions\UserIdentifier\VerifyUserIdentifierByAdminAction;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\UserIdentifierHydrator;
use App\Validators\UserIdentifierValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class CreateUserIdentifierByAdminApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class CreateUserIdentifierByAdminApi
{
    /**
     * @var AddUserIdentifierAction
     */
    private AddUserIdentifierAction $addUserIdentifierAction;

    /**
     * @var UserIdentifierHydrator
     */
    private UserIdentifierHydrator $userIdentifierHydrator;

    /**
     * @var UserIdentifierValidator
     */
    private UserIdentifierValidator $userIdentifierValidator;

    /**
     * @var GetUserIdentifierAction
     */
    private GetUserIdentifierAction $getUserIdentifierAction;

    /**
     * @param VerifyUserIdentifierByAdminAction
     */
    private VerifyUserIdentifierByAdminAction $verifyUserIdentifierByAdminAction;

    /**
     * CreateUserIdentifierApi constructor.
     * @param AddUserIdentifierAction $addUserIdentifierAction
     * @param UserIdentifierHydrator $userIdentifierHydrator
     * @param UserIdentifierValidator $userIdentifierValidator
     * @param GetUserIdentifierAction $getUserIdentifierAction
     * @param VerifyUserIdentifierByAdminAction $verifyUserIdentifierByAdminAction
     */
    public function __construct(
        AddUserIdentifierAction $addUserIdentifierAction,
        UserIdentifierHydrator $userIdentifierHydrator,
        UserIdentifierValidator $userIdentifierValidator,
        GetUserIdentifierAction $getUserIdentifierAction,
        VerifyUserIdentifierByAdminAction $verifyUserIdentifierByAdminAction
    )
    {
        $this->addUserIdentifierAction = $addUserIdentifierAction;
        $this->userIdentifierHydrator = $userIdentifierHydrator;
        $this->userIdentifierValidator = $userIdentifierValidator;
        $this->getUserIdentifierAction = $getUserIdentifierAction;
        $this->verifyUserIdentifierByAdminAction = $verifyUserIdentifierByAdminAction;
    }

    /**
     * @return JsonResponse
     * @throws ValidationException
     * @throws CorruptedDataException
     */
    public function __invoke(): JsonResponse
    {
        $this->userIdentifierValidator->validateCreateUserIdentifierByAdmin(request()->only('type', 'value', 'user_id'));

        $userIdentifier = $this->getUserIdentifierAction->__invoke(request('type'), request('value'));

        if(!is_null($userIdentifier) && $userIdentifier->isNotVerified()) {
            $userIdentifier = $this->verifyUserIdentifierByAdminAction->__invoke($userIdentifier);
        }
        if(!is_null($userIdentifier)) {
            ### we have two options here either return current identifier or throw exception
            ### update it and set is_verified = true

            return response()->json($this->userIdentifierHydrator->fromEntity($userIdentifier)->toArray());
        }

        $userIdentifier = (new UserIdentifierEntity())
            ->setType(request('type'))
            ->setValue(request('value'))
            ->setIsVerified(true)
            ->setUserId(request('user_id'));


        // todo: remove all other identifiers with this type and value
        // which are not verified
        $persistedUserIdentifier = $this->addUserIdentifierAction->__invoke($userIdentifier);

        return response()->json($this->userIdentifierHydrator->fromEntity($persistedUserIdentifier)->toArray());
    }


}
