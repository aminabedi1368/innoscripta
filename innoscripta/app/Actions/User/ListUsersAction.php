<?php
namespace App\Actions\User;

use App\Exceptions\CorruptedDataException;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Repos\UserRepository;

/**
 * Class ListUsersAction
 * @package App\Actions\User
 */
class ListUsersAction
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * ListUsersAction constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ListCriteria $listCriteria
     * @param string|null $search
     * @return PaginatedEntityList
     * @throws CorruptedDataException
     */
    public function __invoke(ListCriteria $listCriteria, ?string $search): PaginatedEntityList
    {
        return $this->userRepository->listUsers($listCriteria, $search);
    }

}
