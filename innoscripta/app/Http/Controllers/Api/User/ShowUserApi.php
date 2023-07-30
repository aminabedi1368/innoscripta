<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\GetUserProfileAction;
use App\Hydrators\UserHydrator;

/**
 * Class ShowUserApi
 * @package App\Http\Controllers\Api\User
 */
class ShowUserApi
{
    /**
     * @var GetUserProfileAction
     */
    private GetUserProfileAction $getUserProfileAction;

    /**
     * @var UserHydrator
     */
    private UserHydrator $userHydrator;

    /**
     * ShowUserApi constructor.
     * @param GetUserProfileAction $getUserProfileAction
     */
    public function __construct(
        GetUserProfileAction $getUserProfileAction,
        UserHydrator $userHydrator
    )
    {
        $this->getUserProfileAction = $getUserProfileAction;
        $this->userHydrator = $userHydrator;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function __invoke(int $id)
    {
        $user = $this->getUserProfileAction->__invoke($id);

        $userArray = $this->userHydrator->fromEntity($user)->toArray();

        return response()->json($userArray);
    }

}
