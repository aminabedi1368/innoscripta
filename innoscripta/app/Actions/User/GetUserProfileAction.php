<?php
namespace App\Actions\User;

use App\Entities\UserEntity;
use App\Repos\UserRepository;

/**
 * Class GetUserProfileAction
 * @package App\Actions\User
 */
class GetUserProfileAction
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * GetUserProfileAction constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int | UserEntity $user
     * @return UserEntity
     */
    public function __invoke($user)
    {
        $userEntity = $user;

        if(is_int($user)) {
            $userEntity = $this->userRepository->findOneById($user);
        }

        return $userEntity;
    }

}
