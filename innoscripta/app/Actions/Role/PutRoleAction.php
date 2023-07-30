<?php
namespace App\Actions\Role;

use App\Entities\RoleEntity;
use App\Repos\RoleRepository;

/**
 * Class UpdateRoleAction
 * @package App\Actions\Project
 */
class PutRoleAction
{

    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * UpdateRoleAction constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param RoleEntity $roleEntity
     * @return RoleEntity
     */
    public function __invoke(RoleEntity $roleEntity): RoleEntity
    {
        return $this->roleRepository->updateRole($roleEntity);
    }

}
