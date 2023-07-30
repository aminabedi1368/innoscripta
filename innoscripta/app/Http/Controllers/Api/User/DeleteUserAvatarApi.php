<?php
namespace App\Http\Controllers\Api\User;

use App\Repos\UserRepository;
use Illuminate\Http\Response;

/**
 * DeleteUserAvatarApi
 */
class DeleteUserAvatarApi
{

    /**
     * @var UserRepository $userRepository
     */
    private UserRepository $userRepository;


    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param integer $id
     * @return Response
     */
    public function __invoke(int $id)
    {
        $this->userRepository->deleteUserAvatr($id);

        return response()->noContent();
    }

}
