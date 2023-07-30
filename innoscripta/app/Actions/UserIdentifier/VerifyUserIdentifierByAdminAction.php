<?php
namespace App\Actions\UserIdentifier;

use App\Entities\UserIdentifierEntity;
use App\Exceptions\UserIdentifier\UserIdentifierAlreadyVerifiedException;
use App\Repos\UserIdentifierRepository;

/**
 * Class VerifyUserIdentifierByAdminAction
 * @package App\Actions\UserIdentifier
 */
class VerifyUserIdentifierByAdminAction
{
    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;


    /**
     * VerifyUserIdentifierAction constructor.
     * @param UserIdentifierRepository $userIdentifierRepository
     * @param OtpRepository $otpRepository
     */
    public function __construct(UserIdentifierRepository $userIdentifierRepository)
    {
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     * @throws UserIdentifierAlreadyVerifiedException
     *
     * @return UserIdentifierEntity
     */
    public function __invoke(UserIdentifierEntity $userIdentifierEntity)
    {
        if($userIdentifierEntity->isNotVerified()) {
            $this->userIdentifierRepository->verifyIdentifier($userIdentifierEntity->getValue());
        }

        return $userIdentifierEntity->setIsVerified(true);
    }

}
