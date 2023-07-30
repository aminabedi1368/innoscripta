<?php
namespace App\Actions\User;

use App\Entities\UserEntity;
use App\Exceptions\CorruptedDataException;
use App\Repos\UserRepository;
use Illuminate\Http\UploadedFile;

/**
 * Class UploadUserAvatarAction
 * @package App\Actions\User
 */
class UploadUserAvatarAction
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UploadUserAvatarAction constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @param UserEntity $userEntity
     * @param UploadedFile $uploadedFile
     * @return UserEntity
     * @throws CorruptedDataException
     */
    public function __invoke(UserEntity $userEntity, UploadedFile $uploadedFile)
    {
        $path = $uploadedFile->store('/public/avatar');
        $userEntity->setAvatar($path);
        return $this->userRepository->updateUserAvatar($userEntity->getIdentifier(), $path);
    }

}
