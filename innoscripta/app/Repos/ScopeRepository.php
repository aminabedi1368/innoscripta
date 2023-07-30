<?php
namespace App\Repos;

use App\Entities\ScopeEntity;
use App\Exceptions\CantUpdateModelWhichIsNotPersistedException;
use App\Hydrators\ScopeHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\ScopeModel;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

/**
 * Class ScopeRepository
 * @package App\Repos
 */
class ScopeRepository implements ScopeRepositoryInterface
{

    use RepoTrait;

    /**
     * @var ScopeModel
     */
    private ScopeModel $scopeModel;

    /**
     * @var ScopeHydrator
     */
    private ScopeHydrator $scopeHydrator;

    /**
     * ScopeRepository constructor.
     * @param ScopeModel $scopeModel
     * @param ScopeHydrator $scopeHydrator
     */
    public function __construct(ScopeModel $scopeModel, ScopeHydrator $scopeHydrator)
    {
        $this->scopeModel = $scopeModel;
        $this->scopeHydrator = $scopeHydrator;
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function listScopes(ListCriteria $listCriteria): PaginatedEntityList
    {
        $paginatedScopes = $this->makePaginatedList($listCriteria, $this->scopeModel);

        $entities = [];

        foreach ($paginatedScopes->getItems() as $item) {
            $entities[] = $this->scopeHydrator->fromArray($item)->toEntity();
        }
        $paginatedScopes->setItems($entities);

        $scopeHydrator = $this->scopeHydrator;

        $paginatedScopes->setItemsToArrayFunction(function(array $items) use ($scopeHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $scopeHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedScopes;
    }

    /**
     * @param ScopeEntity $scopeEntity
     * @return ScopeEntity
     * @throws CantUpdateModelWhichIsNotPersistedException
     */
    public function updateScope(ScopeEntity $scopeEntity): ScopeEntity
    {
        if($scopeEntity->isNotPersisted()) {
            throw new CantUpdateModelWhichIsNotPersistedException;
        }

        $this->scopeModel->newQuery()->where('id', $scopeEntity->getId())->update(
            $this->scopeHydrator->fromEntity($scopeEntity)->toArray()
        );

        return $scopeEntity;
    }

    /**
     * @param int|ScopeEntity $scope
     * @return int
     */
    public function deleteScope(int|ScopeEntity $scope): int
    {
        $scope_id = $scope;

        if($scope instanceof ScopeEntity) {
            $scope_id = $scope->getId();
        }
        $this->scopeModel->getConnection()
            ->table('role_scopes')
            ->where('scope_id', $scope_id)
            ->delete();

        return $this->scopeModel->newQuery()->where('id', $scope_id)->delete();
    }

    /**
     * @param string $identifier
     * @return ScopeEntity|null
     */
    public function getScopeEntityByIdentifier($identifier): ?ScopeEntity
    {
        /** @var ScopeModel $scopeModel */
        $scopeModel = $this->scopeModel->newQuery()->where('slug', $identifier)->firstOrFail();

        return $this->scopeHydrator->fromModel($scopeModel)->toEntity();
    }

    /**
     * @param array $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null $userIdentifier
     * @return array
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ): array
    {
        return $scopes;
    }

    /**
     * @param int $scope_id
     * @param array $relations
     * @return ScopeEntity
     */
    public function findOneById(int $scope_id, array $relations = []): ScopeEntity
    {
        /** @var ScopeModel $scopeModel */
        $scopeModel = $this->scopeModel->newQuery()->with($relations)->findOrFail($scope_id);

        return $this->scopeHydrator->fromModel($scopeModel)->toEntity();
    }


    /**
     * @param ScopeEntity $scopeEntity
     * @return ScopeEntity
     */
    public function insertScope(ScopeEntity $scopeEntity)
    {
        $scopeModel = $this->scopeModel->newQuery()->create(
            $this->scopeHydrator->fromEntity($scopeEntity)->toArray()
        );

        return $scopeEntity->setId($scopeModel->id);
    }

}
