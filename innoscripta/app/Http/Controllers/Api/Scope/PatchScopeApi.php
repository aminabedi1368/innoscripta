<?php
namespace App\Http\Controllers\Api\Scope;

use App\Actions\Scope\PatchScopeAction;
use App\Exceptions\CantUpdateModelWhichIsNotPersistedException;
use App\Hydrators\ScopeHydrator;
use App\Validators\ScopeValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class PatchScopeApi
 * @package App\Http\Controllers\Api\Scope
 */
class PatchScopeApi
{
    /**
     * @var PatchScopeAction
     */
    private PatchScopeAction $patchScopeAction;

    /**
     * @var ScopeHydrator
     */
    private ScopeHydrator $scopeHydrator;

    /**
     * @var ScopeValidator
     */
    private ScopeValidator $scopeValidator;

    /**
     * UpdateScopeApi constructor.
     * @param PatchScopeAction $patchScopeAction
     * @param ScopeHydrator $scopeHydrator
     * @param ScopeValidator $scopeValidator
     */
    public function __construct(
        PatchScopeAction $patchScopeAction,
        ScopeHydrator $scopeHydrator,
        ScopeValidator $scopeValidator
    )
    {
        $this->patchScopeAction = $patchScopeAction;
        $this->scopeHydrator = $scopeHydrator;
        $this->scopeValidator = $scopeValidator;
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws CantUpdateModelWhichIsNotPersistedException
     * @throws ValidationException
     */
    public function __invoke(int $id): JsonResponse
    {
        $data = array_merge(['id' => $id], request()->except('user', 'tokenInfo'));

        $this->scopeValidator->validatePatchScope($data);

        $updatedScope = $this->patchScopeAction->__invoke($data);

        return response()->json($this->scopeHydrator->fromEntity($updatedScope)->toArray());
    }

}
