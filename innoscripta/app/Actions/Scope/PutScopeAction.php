<?php
namespace App\Actions\Scope;

use App\Entities\ScopeEntity;
use App\Repos\ScopeRepository;

/**
 * Class UpdateScopeAction
 * @package App\Actions\Scope
 */
class PutScopeAction
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
     * @param ScopeEntity $scopeEntity
     * @return ScopeEntity
     */
    public function __invoke(ScopeEntity $scopeEntity)
    {
        return $this->scopeRepository->updateScope($scopeEntity);
    }

}
