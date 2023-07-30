<?php
namespace App\Http\Controllers\Api\Role;

use App\Actions\Role\PatchRoleAction;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\RoleHydrator;
use App\Validators\RoleValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class PatchRoleApi
 * @package App\Http\Controllers\Api\Role
 */
class PatchRoleApi
{

    /**
     * @var PatchRoleAction
     */
    private PatchRoleAction $patchRoleAction;

    /**
     * @var RoleValidator
     */
    private RoleValidator $roleValidator;

    /**
     * @var RoleHydrator
     */
    private RoleHydrator $roleHydrator;

    /**
     * UpdateRoleApi constructor.
     * @param RoleValidator $roleValidator
     * @param PatchRoleAction $updateRoleAction
     * @param RoleHydrator $roleHydrator
     */
    public function __construct(
        RoleValidator $roleValidator,
        PatchRoleAction $updateRoleAction,
        RoleHydrator $roleHydrator
    )
    {
        $this->patchRoleAction = $updateRoleAction;
        $this->roleValidator = $roleValidator;
        $this->roleHydrator = $roleHydrator;
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     * @throws CorruptedDataException
     */
    public function __invoke(int $id): JsonResponse
    {
        $data = array_merge(
            ['id' => $id],
             request()->except('user', 'tokenInfo')
        );

        $this->roleValidator->validatePatchRole($data);

        $persistedRoleEntity = $this->patchRoleAction->__invoke($data);

        return response()->json($this->roleHydrator->fromEntity($persistedRoleEntity)->toArray());
    }

}
