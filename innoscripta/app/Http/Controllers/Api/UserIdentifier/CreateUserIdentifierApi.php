<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\UserIdentifier\AddUserIdentifierAction;
use App\Actions\UserIdentifier\GetUserIdentifierAction;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\UserIdentifierHydrator;
use App\Lib\TokenInfoVO;
use App\Validators\UserIdentifierValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class CreateUserIdentifierApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class CreateUserIdentifierApi
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
     * CreateUserIdentifierApi constructor.
     * @param AddUserIdentifierAction $addUserIdentifierAction
     * @param UserIdentifierHydrator $userIdentifierHydrator
     * @param UserIdentifierValidator $userIdentifierValidator
     * @param GetUserIdentifierAction $getUserIdentifierAction
     */
    public function __construct(
        AddUserIdentifierAction $addUserIdentifierAction,
        UserIdentifierHydrator $userIdentifierHydrator,
        UserIdentifierValidator $userIdentifierValidator,
        GetUserIdentifierAction $getUserIdentifierAction
    )
    {
        $this->addUserIdentifierAction = $addUserIdentifierAction;
        $this->userIdentifierHydrator = $userIdentifierHydrator;
        $this->userIdentifierValidator = $userIdentifierValidator;
        $this->getUserIdentifierAction = $getUserIdentifierAction;
    }

    /**
     * @return JsonResponse
     * @throws ValidationException
     * @throws CorruptedDataException
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var TokenInfoVO $tokenInfo */
        $tokenInfo = request('tokenInfo');
        $userEntity = $request->attributes->get('userEntity');

        $this->userIdentifierValidator->validateCreateUserIdentifier(request()->only('type', 'value'));

        $userIdentifier = $this->getUserIdentifierAction->__invoke(request('type'), request('value'));

        if(!is_null($userIdentifier) && $userIdentifier->getUserId() === $userEntity->getId()) {
            ### we have two options here either return current identifier or throw exception
            return response()->json($this->userIdentifierHydrator->fromEntity($userIdentifier)->toArray());
        }

        $userIdentifier = (new UserIdentifierEntity())
            ->setType(request('type'))
            ->setValue(request('value'))
            ->setIsVerified(false)
            ->setUserId($userEntity->getId());


        $persistedUserIdentifier = $this->addUserIdentifierAction->__invoke($userIdentifier);

        return response()->json($this->userIdentifierHydrator->fromEntity($persistedUserIdentifier)->toArray());
    }


}
