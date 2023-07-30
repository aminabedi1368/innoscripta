<?php
namespace App\Actions\Role;

use App\Entities\RoleEntity;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\RoleHydrator;
use App\Repos\RoleRepository;

/**
 * Class PatchRoleAction
 * @package App\Actions\Project
 */
class PatchRoleAction
{

    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * @var RoleHydrator
     */
    private RoleHydrator $roleHydrator;

    /**
     * UpdateRoleAction constructor.
     * @param RoleRepository $roleRepository
     * @param RoleHydrator $roleHydrator
     */
    public function __construct(RoleRepository $roleRepository, RoleHydrator $roleHydrator)
    {
        $this->roleRepository = $roleRepository;
        $this->roleHydrator = $roleHydrator;
    }

    /**
     * @param array $data
     * @return RoleEntity
     * @throws CorruptedDataException
     */
    public function __invoke(array $data): RoleEntity
    {
        $roleEntity = $this->roleRepository->findOneById($data['id']);

        $roleArray = $this->roleHydrator->fromEntity($roleEntity)->toArray();

        $updatedRoleArray = array_merge($roleArray, $data);

        $updatedRoleEntity = $this->roleHydrator->fromArray($updatedRoleArray)->toEntity();

        return $this->roleRepository->updateRole($updatedRoleEntity);
    }

}
