<?php
namespace App\Actions\UserIdentifier;

use App\Entities\UserIdentifierEntity;
use App\Repos\UserIdentifierRepository;

/**
 * Class AddUserIdentifierAction
 * @package App\Actions\UserIdentifier
 */
class AddUserIdentifierAction
{
    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * AddUserIdentifierAction constructor.
     * @param UserIdentifierRepository $userIdentifierRepository
     */
    public function __construct(UserIdentifierRepository $userIdentifierRepository)
    {
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     * @return UserIdentifierEntity
     */
    public function __invoke(UserIdentifierEntity $userIdentifierEntity): UserIdentifierEntity
    {
        return $this->userIdentifierRepository->insertUserIdentifier($userIdentifierEntity);
    }

}
