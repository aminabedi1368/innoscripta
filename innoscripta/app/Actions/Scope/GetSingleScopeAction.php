<?php
namespace App\Actions\Scope;

use App\Entities\ScopeEntity;
use App\Repos\ScopeRepository;

/**
 * Class GetSingleScopeAction
 * @package App\Actions\Scope
 */
class GetSingleScopeAction
{
    /**
     * @var ScopeRepository
     */
    private ScopeRepository $scopeRepository;

    /**
     * GetSingleScopeAction constructor.
     * @param ScopeRepository $scopeRepository
     */
    public function __construct(ScopeRepository $scopeRepository)
    {
        $this->scopeRepository = $scopeRepository;
    }

    /**
     * @param ScopeEntity|int $scope
     */
    public function __invoke($scope)
    {

    }

}
