<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\UploadUserAvatarAction;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\UserHydrator;
use App\Lib\TokenInfoVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UploadUserAvatarApi
 * @package App\Http\Controllers\Api\User
 */
class UploadUserAvatarApi
{

    /**
     * @var UploadUserAvatarAction
     */
    private UploadUserAvatarAction $uploadUserAvatarAction;
    /**
     * @var UserHydrator
     */
    private UserHydrator $userHydrator;

    /**
     * UploadUserAvatarApi constructor.
     * @param UploadUserAvatarAction $uploadUserAvatarAction
     * @param UserHydrator $userHydrator
     */
    public function __construct(UploadUserAvatarAction $uploadUserAvatarAction, UserHydrator $userHydrator)
    {
        $this->uploadUserAvatarAction = $uploadUserAvatarAction;
        $this->userHydrator = $userHydrator;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws CorruptedDataException
     */
    public function __invoke(Request $request)
    {
        $avatarFile = $request->file('avatar');
        /** @var TokenInfoVO $tokenInfo */
//        $tokenInfo = $request->get('tokenInfo');
        $userEntity = $request->attributes->get('userEntity');

        $userEntity = $this->uploadUserAvatarAction->__invoke($userEntity, $avatarFile);

        return response()->json($this->userHydrator->fromEntity($userEntity)->toArray());
    }

}
