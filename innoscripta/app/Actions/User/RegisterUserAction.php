<?php
namespace App\Actions\User;

use App\Entities\UserEntity;
use App\Repos\UserRepository;
use Illuminate\Hashing\HashManager;

/**
 * Class RegisterUserAction
 * @package App\Actions\User
 */
class RegisterUserAction
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var HashManager
     */
    private HashManager $hashManager;

    /**
     * RegisterUserAction constructor.
     * @param UserRepository $userRepository
     * @param HashManager $hashManager
     */
    public function __construct(UserRepository $userRepository, HashManager $hashManager)
    {
        $this->userRepository = $userRepository;
        $this->hashManager = $hashManager;
    }

    /**
     * @param UserEntity $userEntity
     * @return UserEntity
     */
    public function __invoke(UserEntity $userEntity)
    {
        $userEntity->setPassword(
            $this->hashManager->make($userEntity->getPassword())
        );
        return $this->userRepository->insert($userEntity);
    }

}
