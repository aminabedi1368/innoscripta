<?php
namespace App\Actions\Role;

use App\Entities\RoleEntity;
use App\Exceptions\CorruptedDataException;
use App\Repos\RoleRepository;

/**
 * Class CreateRoleAction
 * @package App\Actions\Project
 */
class CreateRoleAction
{

    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * CreateRoleAction constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }


    /**
     * @param RoleEntity $roleEntity
     * @return RoleEntity
     * @throws CorruptedDataException
     */
    public function __invoke(RoleEntity $roleEntity): RoleEntity
    {
        return $this->roleRepository->createRole($roleEntity);
    }

}
