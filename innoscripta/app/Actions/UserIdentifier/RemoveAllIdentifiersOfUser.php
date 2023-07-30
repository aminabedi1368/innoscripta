<?php
namespace App\Actions\UserIdentifier;

use App\Repos\UserIdentifierRepository;

/**
 * RemoveAllIdentifiersOfUser
 */
class RemoveAllIdentifiersOfUser
{

    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * @param UserIdentifierRepository $userIdentifierRepository
     */
    public function __construct(UserIdentifierRepository $userIdentifierRepository)
    {
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * @param integer $userId
     * @return void
     */
    public function __invoke(int $userId)
    {
        $this->userIdentifierRepository->deleteAllIdentifiersOfUser($userId);
    }

}
