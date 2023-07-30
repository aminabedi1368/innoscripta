<?php
namespace App\Actions\Scope;

use App\Repos\ScopeRepository;

/**
 * Class ShowScopeAction
 * @package App\Actions\Scope
 */
class ShowScopeAction
{
    /**
     * @var ScopeRepository
     */
    private ScopeRepository $scopeRepository;

    /**
     * ShowScopeAction constructor.
     * @param ScopeRepository $scopeRepository
     */
    public function __construct(ScopeRepository $scopeRepository)
    {
        $this->scopeRepository = $scopeRepository;
    }

    /**
     * @param int $scope_id
     */
    public function __invoke(int $scope_id)
    {
        // TODO: Implement __invoke() method.
    }

}
