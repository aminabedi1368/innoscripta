<?php
namespace App\Actions\UserIdentifier;

use App\Entities\UserEntity;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Repos\UserIdentifierRepository;

/**
 * Class ListUserIdentifiersAction
 * @package App\Actions\UserIdentifier
 */
class ListUserIdentifiersAction
{

    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * ListUserIdentifiersAction constructor.
     * @param UserIdentifierRepository $userIdentifierRepository
     */
    public function __construct(UserIdentifierRepository $userIdentifierRepository)
    {
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * @param UserEntity|int $user
     * @return UserIdentifierEntity[]
     * @throws CorruptedDataException
     */
    public function __invoke($user)
    {
        return $this->userIdentifierRepository->listUserIdentifiers($user);
    }

}
