<?php
namespace App\Actions\Scope;

use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Repos\ScopeRepository;

/**
 * Class ListScopeAction
 * @package App\Actions\Scope
 */
class ListScopeAction
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
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function __invoke(ListCriteria $listCriteria): PaginatedEntityList
    {
        return $this->scopeRepository->listScopes($listCriteria);
    }

}
