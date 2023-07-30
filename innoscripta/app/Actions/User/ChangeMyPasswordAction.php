<?php
namespace App\Actions\User;

use App\Entities\UserEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Repos\UserRepository;
use Illuminate\Hashing\HashManager;

/**
 * Class ChangeMyPasswordAction
 * @package App\Actions\User
 */
class ChangeMyPasswordAction
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
     * ChangeMyPasswordAction constructor.
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
     * @param string $old_password
     * @param string $new_password
     * @throws InvalidUserCredentialsException
     */
    public function __invoke(UserEntity $userEntity, string $old_password, string $new_password)
    {
        $doesPasswordMatch = $this->hashManager->check($old_password, $userEntity->getPassword());

        if(!$doesPasswordMatch) {
            throw new InvalidUserCredentialsException;
        }

        $this->userRepository->updatePassword($userEntity->getIdentifier(), $this->hashManager->make($new_password));
    }

}
