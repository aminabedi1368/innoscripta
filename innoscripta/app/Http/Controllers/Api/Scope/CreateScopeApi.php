<?php
namespace App\Http\Controllers\Api\Scope;

use App\Actions\Scope\CreateScopeAction;
use App\Hydrators\ScopeHydrator;
use App\Validators\ScopeValidator;

/**
 * Class CreateScopeApi
 * @package App\Http\Controllers\Api\Scope
 */
class CreateScopeApi
{
    /**
     * @var CreateScopeAction
     */
    private CreateScopeAction $createScopeAction;

    /**
     * @var ScopeValidator
     */
    private ScopeValidator $scopeValidator;

    /**
     * @var ScopeHydrator
     */
    private ScopeHydrator $scopeHydrator;

    /**
     * @param CreateScopeAction $createScopeAction
     * @param ScopeValidator $scopeValidator
     */
    public function __construct(
        CreateScopeAction $createScopeAction,
        ScopeValidator $scopeValidator,
        ScopeHydrator $scopeHydrator
    )
    {
        $this->createScopeAction = $createScopeAction;
        $this->scopeValidator = $scopeValidator;
        $this->scopeHydrator = $scopeHydrator;
    }

    public function __invoke()
    {
        $requestData = request()->except('tokenInfo');

        $this->scopeValidator->validateCreateScope($requestData);

        $scopeEntity = $this->scopeHydrator->fromArray($requestData)->toEntity();

        $persistedScopeEntity = $this->createScopeAction->__invoke($scopeEntity);

        return response()->json(
            $this->scopeHydrator->fromEntity($persistedScopeEntity)->toArray()
        );
    }

}
