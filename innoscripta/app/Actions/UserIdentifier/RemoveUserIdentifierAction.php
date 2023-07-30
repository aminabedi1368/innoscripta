<?php
namespace App\Actions\UserIdentifier;

use App\Repos\UserIdentifierRepository;

/**
 * Class RemoveUserIdentifierAction
 * @package App\Actions\UserIdentifier
 */
class RemoveUserIdentifierAction
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
     * @param int $userIdentifierId
     */
    public function __invoke(int $userIdentifierId)
    {
        $this->userIdentifierRepository->deleteIdentifierById($userIdentifierId);
    }

}
