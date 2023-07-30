<?php
namespace App\Repos;

use App\Entities\ProjectEntity;
use App\Hydrators\ProjectHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Lib\ListView\RepoTrait;
use App\Models\ProjectModel;

/**
 * Class ProjectRepository
 * @package App\Repos
 */
class ProjectRepository
{

    use RepoTrait;

    /**
     * @var ProjectModel
     */
    private ProjectModel $projectModel;

    /**
     * @var ProjectHydrator
     */
    private ProjectHydrator $projectHydrator;

    /**
     * ProjectRepository constructor.
     * @param ProjectModel $projectModel
     * @param ProjectHydrator $projectHydrator
     */
    public function __construct(ProjectModel $projectModel, ProjectHydrator $projectHydrator)
    {
        $this->projectModel = $projectModel;
        $this->projectHydrator = $projectHydrator;
    }

    /**
     * @param int $id
     * @param array $with
     * @param bool $throw_exception
     * @return ProjectEntity
     */
    public function findProjectById(int $id, array $with = [], $throw_exception = true)
    {
        /** @var ProjectModel $projectModel */
        $query = $this->projectModel->newQuery()->with($with);

        if($throw_exception) {
            $projectModel = $query->findOrFail($id);
        }
        else {
            $projectModel = $query->find($id);
        }

        return $this->projectHydrator->fromModel($projectModel)->toEntity();
    }

    /**
     * @param ProjectEntity $projectEntity
     * @return ProjectEntity
     */
    public function createProject(ProjectEntity $projectEntity)
    {
        /** @var ProjectModel $projectModel */
        $projectModel = $this->projectModel->newQuery()->create(
            $this->projectHydrator->fromEntity($projectEntity)->toArray()
        );

        return $projectEntity->setId($projectModel->id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id)
    {
        return $this->projectModel->newQuery()->where('id', $id)->delete();
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function listProjects(ListCriteria $listCriteria)
    {
        $paginatedProjects =  $this->makePaginatedList($listCriteria, $this->projectModel);

        $entities = [];

        foreach ($paginatedProjects->getItems() as $item) {
            $entities[] = $this->projectHydrator->fromArray($item)->toEntity();
        }
        $paginatedProjects->setItems($entities);

        $projectHydrator = $this->projectHydrator;

        $paginatedProjects->setItemsToArrayFunction(function(array $items) use ($projectHydrator) {
            $res = [];
            foreach ($items as $item) {
                $res[] = $projectHydrator->fromEntity($item)->toArray();
            }
            return $res;
        });

        return $paginatedProjects;
    }


}
