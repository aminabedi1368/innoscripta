<?php
namespace App\Actions\User;

use App\Entities\UserEntity;
use App\Exceptions\CantUpdateModelWhichIsNotPersistedException;
use App\Exceptions\CorruptedDataException;
use App\Repos\UserRepository;

/**
 * Class UpdateUserAction
 * @package App\Actions\User
 */
class UpdateUserAction
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UpdateUserAction constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $user_id
     * @param string $first_name
     * @param string $last_name
     * @return UserEntity
     * @throws CorruptedDataException
     */
    public function __invoke(int $user_id, string $first_name, string $last_name)
    {
        return $this->userRepository->updateUser($user_id, $first_name, $last_name);
    }

}
