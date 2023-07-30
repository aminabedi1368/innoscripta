<?php
namespace App\Actions\Scope;

use App\Entities\ScopeEntity;
use App\Repos\ScopeRepository;

/**
 * Class DeleteScopeAction
 * @package App\Actions\Scope
 */
class DeleteScopeAction
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
     * @param int|ScopeEntity $id
     */
    public function __invoke(int|ScopeEntity $id)
    {
        $this->scopeRepository->deleteScope($id);
    }

}
