<?php
namespace App\Actions\Role;

use App\Exceptions\CorruptedDataException;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Repos\RoleRepository;

/**
 * Class ListRoleAction
 * @package App\Actions\Project
 */
class ListRoleAction
{
    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;


    /**
     * ListRoleAction constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     * @throws CorruptedDataException
     */
    public function __invoke(ListCriteria $listCriteria): PaginatedEntityList
    {
        return $this->roleRepository->listRoles($listCriteria);
    }

}
