<?php
namespace App\Actions\Role;

use App\Entities\RoleEntity;
use App\Repos\RoleRepository;

/**
 * Class ShowSingleRoleAction
 * @package App\Actions\Project
 */
class ShowSingleRoleAction
{
    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;


    /**
     * ShowSingleRoleAction constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param int $role_id
     * @return RoleEntity
     */
    public function __invoke(int $role_id)
    {
        return $this->roleRepository->findOneById($role_id);
    }

}
