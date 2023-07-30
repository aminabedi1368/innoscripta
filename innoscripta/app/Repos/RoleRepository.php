<?php
namespace App\Repos;

use App\Entities\RoleEntity;
use App\Exceptions\CorruptedDataException;
use App\Hydrators\RoleHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\RoleModel;
use App\Models\ScopeModel;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleRepository
 * @package App\Repos
 */
class RoleRepository
{

    use RepoTrait;

    /**
     * @var RoleModel
     */
    private RoleModel $roleModel;

    /**
     * @var RoleHydrator
     */
    private RoleHydrator $roleHydrator;

    /**
     * RoleRepository constructor.
     * @param RoleModel $roleModel
     * @param RoleHydrator $roleHydrator
     */
    public function __construct(RoleModel $roleModel, RoleHydrator $roleHydrator)
    {
        $this->roleModel = $roleModel;
        $this->roleHydrator = $roleHydrator;
    }


    /**
     * @param RoleEntity $roleEntity
     * @return RoleEntity
     * @throws CorruptedDataException
     */
    public function createRole(RoleEntity $roleEntity): RoleEntity
    {
        $roleArray = $this->roleHydrator->fromEntity($roleEntity)->toArray();

        /** @var RoleModel $persistedRoleModel */
        $persistedRoleModel = $this->roleModel->newQuery()->create($roleArray);

        $scopesArray = [];

        if(array_key_exists('scopes', $roleArray)) {
            foreach ($roleArray['scopes'] as $scopeArray) {

                ### scope exists so just attach it to the role
                if(array_key_exists('id', $scopeArray)) {
                    ## do nothing
                }
                ### scope doesn't exist so first create the scope and then attach it to the role
                else {
                    /** @var ScopeModel $scopeModel */
                    $scopeModel = ScopeModel::query()->create($scopeArray);
                    $scopeArray = $scopeModel->toArray();
                }

                $scopesArray[] = $scopeArray;
            }
        }

        $persistedRoleModel->scopes()->attach(array_column($scopesArray, 'id'));

        /** @var RoleModel $roleModel */
        $roleModel = RoleModel::query()
            ->with('scopes')
            ->where('id',$persistedRoleModel->id)
            ->firstOrFail();

        return $this->roleHydrator->fromModel($roleModel)->toEntity();
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     * @throws CorruptedDataException
     */
    public function listRoles(ListCriteria $listCriteria): PaginatedEntityList
    {
        $paginatedRoles =  $this->makePaginatedList($listCriteria, $this->roleModel);

        $entities = [];

        foreach ($paginatedRoles->getItems() as $item) {
            $entities[] = $this->roleHydrator->fromArray($item)->toEntity();
        }
        $paginatedRoles->setItems($entities);

        $roleHydrator = $this->roleHydrator;

        $paginatedRoles->setItemsToArrayFunction(function(array $items) use ($roleHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $roleHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedRoles;
    }


    /**
     * @param ListCriteria $list_criteria
     * @param Model $model
     * @return PaginatedEntityList
     */
    public function makePaginatedList(ListCriteria $list_criteria, Model $model): PaginatedEntityList
    {
        $query = $model->newQuery();

        $query = $this->buildFiltersQuery($query, $list_criteria, $model);
        $query = $this->buildSortQuery($query, $list_criteria, $model);
        $query = $this->buildFieldsQuery($query, $list_criteria->getFields(), $model);

        $query->with(['scopes']);

        return (new PaginatedEntityList())
            ->setTotal($query->count())
            ->setLimit($list_criteria->getLimit())
            ->setOffset($list_criteria->getOffset())
            ->setItems($query->offset($list_criteria->getOffset())->take($list_criteria->getLimit())->get()->toArray());
    }

    /**
     * @param int $role_id
     * @return bool
     */
    public function doesRoleHaveScope(int $role_id): bool
    {
        /** @var RoleModel $role */
        $role = $this->roleModel->newQuery()->findOrFail($role_id);

        return $role->scopes()->exists();
    }

    /**
     * @param int $role_id
     * @return bool
     */
    public function doesRoleHaveUser(int $role_id): bool
    {
        /** @var RoleModel $role */
        $role = $this->roleModel->newQuery()->findOrFail($role_id);

        return $role->users()->exists();
    }

    /**
     * @param int $role_id
     * @return int
     * @throws Exception
     */
    public function deleteRole(int $role_id): int
    {
        return $this->roleModel->destroy($role_id);
    }

    /**
     * @param int $role_id
     * @param array $relations
     * @return RoleEntity
     * @throws CorruptedDataException
     */
    public function findOneById(int $role_id, array $relations = []): RoleEntity
    {
        /** @var RoleModel $roleModel */
        $roleModel = $this->roleModel->newQuery()->with($relations)->findOrFail($role_id);

        return $this->roleHydrator->fromModel($roleModel)->toEntity();
    }

    /**
     * @param RoleEntity $roleEntity
     * @return RoleEntity
     */
    public function updateRole(RoleEntity $roleEntity): RoleEntity
    {
        $roleArray = $this->roleHydrator->fromEntity($roleEntity)->toArray();

        $this->roleModel->newQuery()
            ->where('id', $roleEntity->getId())
            ->firstOrFail()
            ->update($roleArray);

        if(array_key_exists('scopes', $roleArray)) {
            $scopesArray = [];
            foreach ($roleArray['scopes'] as $scopeArray) {

                ### scope exists so just attach it to the role
                if(array_key_exists('id', $scopeArray)) {
                    ## do nothing
                }
                ### scope doesn't exist so first create the scope and then attach it to the role
                else {
                    /** @var ScopeModel $scopeModel */
                    $scopeModel = ScopeModel::query()->create($scopeArray);
                    $scopeArray = $scopeModel->toArray();
                }

                $scopesArray[] = $scopeArray;
            }


            /** @var RoleModel $roleModel */
            $roleModel = RoleModel::query()->where('id', $roleEntity->getId())->firstOrFail();

            $roleModel->scopes()->sync([]);
            $roleModel->scopes()->attach(array_column($scopesArray, 'id'));

        }

        return $roleEntity;
    }

}
