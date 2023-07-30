<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\UploadUserAvatarAction;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\UserHydrator;
use App\Repos\UserRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class UploadUserAvatarApi
 * @package App\Http\Controllers\Api\User
 */
class UploadUserAvatarByAdminApi
{

    /**
     * @var UploadUserAvatarAction
     */
    private UploadUserAvatarAction $uploadUserAvatarAction;

    /**
     * @var UserRepository $userRepository
     */
    private UserRepository $userRepository;

    /**
     * @var UserHydrator
     */
    private UserHydrator $userHydrator;

    /**
     * UploadUserAvatarApi constructor.
     * @param UploadUserAvatarAction $uploadUserAvatarAction
     * @param UserHydrator $userHydrator
     * @param UserRepository $userRepository
     */
    public function __construct(
        UploadUserAvatarAction $uploadUserAvatarAction,
        UserRepository $userRepository,
        UserHydrator $userHydrator
    )
    {
        $this->uploadUserAvatarAction = $uploadUserAvatarAction;
        $this->userHydrator = $userHydrator;
        $this->userRepository = $userRepository;
    }


    /**
     * @param int $id => user_id
     * @return JsonResponse
     * @throws CorruptedDataException
     */
    public function __invoke(int $id)
    {
        $avatarFile = request()->file('avatar');

        $userEntity = $this->userRepository->findOneById($id);

        $userEntity = $this->uploadUserAvatarAction->__invoke($userEntity, $avatarFile);

        return response()->json($this->userHydrator->fromEntity($userEntity)->toArray());
    }

}
