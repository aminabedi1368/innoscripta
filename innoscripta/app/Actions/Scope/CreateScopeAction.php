<?php
namespace App\Actions\Scope;

use App\Entities\ScopeEntity;
use App\Repos\ScopeRepository;

/**
 * Class CreateScopeAction
 * @package App\Actions\Scope
 */
class CreateScopeAction
{
    /**
     * @var ScopeRepository
     */
    private ScopeRepository $scopeRepository;

    /**
     * CreateScopeAction constructor.
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
        return $this->scopeRepository->insertScope($scopeEntity);
    }

}
