<?php
namespace App\Http\Controllers\Api\Role;

use App\Actions\Role\CreateRoleAction;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\RoleHydrator;
use App\Validators\RoleValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class RoleController
 * @package App\Http\Controllers\Api
 */
class CreateRoleApi
{

    /**
     * @var RoleValidator
     */
    private RoleValidator $roleValidator;

    /**
     * @var RoleHydrator
     */
    private RoleHydrator $roleHydrator;

    /**
     * @var CreateRoleAction
     */
    private CreateRoleAction $createRoleAction;


    /**
     * CreateRoleApi constructor.
     * @param RoleValidator $roleValidator
     * @param RoleHydrator $roleHydrator
     * @param CreateRoleAction $createRoleAction
     */
    public function __construct(
        RoleValidator $roleValidator,
        RoleHydrator $roleHydrator,
        CreateRoleAction $createRoleAction
    )
    {
        $this->roleValidator = $roleValidator;
        $this->roleHydrator = $roleHydrator;
        $this->createRoleAction = $createRoleAction;
    }

    /**
     * @return JsonResponse
     * @throws ValidationException
     * @throws CorruptedDataException
     */
    public function __invoke(): JsonResponse
    {
        ### 1) validate input data
        $this->roleValidator->validateCreateRole($inputData = request()->all());

        ### 2) Create role entity from input data (Hydrate from array to entity)
        $roleEntity = $this->roleHydrator->fromArray($inputData)->toEntity();

        ### 3) call create role action on role entity and get persisted entity
        $persistedRoleEntity = $this->createRoleAction->__invoke($roleEntity);

        ### 4) return response (persisted entity)
        return response()->json($this->roleHydrator->fromEntity($persistedRoleEntity)->toArray(), 201);
    }


}
