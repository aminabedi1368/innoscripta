<?php
namespace App\Actions\UserIdentifier;

use App\Entities\UserIdentifierEntity;
use App\Repos\UserIdentifierRepository;

/**
 * Class ChangeUserIdentifierIsVerifiedAction
 * @package App\Actions\UserIdentifier
 */
class ChangeUserIdentifierIsVerifiedAction
{

    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * VerifyUserIdentifierAction constructor.
     * @param UserIdentifierRepository $userIdentifierRepository
     */
    public function __construct(UserIdentifierRepository $userIdentifierRepository)
    {
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     */
    public function __invoke(UserIdentifierEntity $userIdentifierEntity)
    {
        $this->userIdentifierRepository->verifyIdentifier($userIdentifierEntity);
    }

}
