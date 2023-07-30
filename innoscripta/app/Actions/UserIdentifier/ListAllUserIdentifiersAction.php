<?php
namespace App\Actions\UserIdentifier;

use App\Exceptions\CorruptedDataException;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Repos\UserIdentifierRepository;

/**
 * Class ListAllUserIdentifiersAction
 * @package App\Actions\UserIdentifier
 */
class ListAllUserIdentifiersAction
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
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     * @throws CorruptedDataException
     */
    public function __invoke(ListCriteria $listCriteria)
    {
        return $this->userIdentifierRepository->listAllUserIdentifiers($listCriteria);
    }

}
