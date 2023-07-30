<?php
namespace App\Actions\User;

use App\Actions\UserIdentifier\RemoveAllIdentifiersOfUser;
use App\Repos\UserRepository;

/**
 * Class DeleteUserAction
 * @package App\Actions\User
 */
class DeleteUserAction
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var RemoveAllIdentifiersOfUser
     */
    private RemoveAllIdentifiersOfUser $removeAllIdentifiersOfUser;

    /**
     * DeleteUserAction constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        RemoveAllIdentifiersOfUser $removeAllIdentifiersOfUser
    )
    {
        $this->userRepository = $userRepository;
        $this->removeAllIdentifiersOfUser = $removeAllIdentifiersOfUser;
    }


    /**
     * @param int $user
     * @return int
     */
    public function __invoke($userId)
    {
        // first delete relations
        // 1) delete user identifiers
        $this->removeAllIdentifiersOfUser->__invoke($userId);


        return $this->userRepository->deleteUser($userId);
    }

}
