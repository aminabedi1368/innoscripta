<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\DeleteUserAction;
use App\Exceptions\Role\CantDeleteRoleWithRelationsException;
use App\Lib\TokenInfoVO;

/**
 * Class DeleteUserApi
 * @package App\Http\Controllers\Api\User
 */
class DeleteUserApi
{
    /**
     * @var DeleteUserAction
     */
    private DeleteUserAction $deleteUserAction;

    /**
     * DeleteUserApi constructor.
     * @param DeleteUserAction $deleteUserAction
     */
    public function __construct(DeleteUserAction $deleteUserAction)
    {
        $this->deleteUserAction = $deleteUserAction;
    }

    /**
     * @param int $id
     */
    public function __invoke(int $id)
    {
                /**
         * @var TokenInfoVO $tokenInfo
         */
        $tokenInfo = request('tokenInfo');

        if($tokenInfo?->getUserEntity()?->getId() === $id) {
            throw new CantDeleteRoleWithRelationsException;
        }

        $this->deleteUserAction->__invoke($id);

        return response()->noContent();
    }

}
