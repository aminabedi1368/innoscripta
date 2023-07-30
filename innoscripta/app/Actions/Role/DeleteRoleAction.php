<?php
namespace App\Actions\Role;

use App\Exceptions\Role\CantDeleteRoleWithRelationsException;
use App\Repos\RoleRepository;
use Exception;

/**
 * Class DeleteRoleAction
 * @package App\Actions\Project
 */
class DeleteRoleAction
{

    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * DeleteRoleAction constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param int $role_id
     * @return int
     * @throws CantDeleteRoleWithRelationsException
     * @throws Exception
     */
    public function __invoke(int $role_id)
    {
        if(
            $this->roleRepository->doesRoleHaveScope($role_id) ||
            $this->roleRepository->doesRoleHaveUser($role_id)
        ) {
            throw new CantDeleteRoleWithRelationsException;
        }

        return $this->roleRepository->deleteRole($role_id);
    }

}
