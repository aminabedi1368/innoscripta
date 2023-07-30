<?php
namespace App\Http\Controllers\Api\Role;

use App\Actions\Role\PutRoleAction;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\RoleHydrator;
use App\Validators\RoleValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class PutRoleApi
 * @package App\Http\Controllers\Api\Role
 */
class PutRoleApi
{

    /**
     * @var PutRoleAction
     */
    private PutRoleAction $updateRoleAction;

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
     * @param PutRoleAction $updateRoleAction
     * @param RoleHydrator $roleHydrator
     */
    public function __construct(
        RoleValidator $roleValidator,
        PutRoleAction $updateRoleAction,
        RoleHydrator $roleHydrator
    )
    {
        $this->updateRoleAction = $updateRoleAction;
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
        $data = array_merge(['id' => $id], request()->all());

        $this->roleValidator->validatePutRole($data);

        $roleEntity = $this->roleHydrator->fromArray($data)->toEntity();

        $persistedRoleEntity = $this->updateRoleAction->__invoke($roleEntity);

        return response()->json($this->roleHydrator->fromEntity($persistedRoleEntity)->toArray());
    }

}
