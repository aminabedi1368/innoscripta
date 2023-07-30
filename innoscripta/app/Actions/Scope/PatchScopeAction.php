<?php
namespace App\Actions\Scope;

use App\Entities\ScopeEntity;
use App\Exceptions\CantUpdateModelWhichIsNotPersistedException;
use App\Hydrators\ScopeHydrator;
use App\Repos\ScopeRepository;

/**
 * Class PatchScopeAction
 * @package App\Actions\Scope
 */
class PatchScopeAction
{
    /**
     * @var ScopeRepository
     */
    private ScopeRepository $scopeRepository;

    /**
     * @var ScopeHydrator
     */
    private ScopeHydrator $scopeHydrator;

    /**
     * GetSingleScopeAction constructor.
     * @param ScopeRepository $scopeRepository
     * @param ScopeHydrator $scopeHydrator
     */
    public function __construct(ScopeRepository $scopeRepository, ScopeHydrator $scopeHydrator)
    {
        $this->scopeRepository = $scopeRepository;
        $this->scopeHydrator = $scopeHydrator;
    }

    /**
     * @param array $data
     * @return ScopeEntity
     * @throws CantUpdateModelWhichIsNotPersistedException
     */
    public function __invoke(array $data): ScopeEntity
    {
        $scopeEntity = $this->scopeRepository->findOneById($data['id']);

        $scopeArray = $this->scopeHydrator->fromEntity($scopeEntity)->toArray();

        $updatedScopeArray = array_merge($scopeArray, $data);

        $updatedScopeEntity = $this->scopeHydrator->fromArray($updatedScopeArray)->toEntity();

        return $this->scopeRepository->updateScope($updatedScopeEntity);
    }

}
