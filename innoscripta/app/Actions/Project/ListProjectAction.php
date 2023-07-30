<?php
namespace App\Actions\Project;

use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Repos\ProjectRepository;

/**
 * Class ListProjectAction
 * @package App\Actions\Project
 */
class ListProjectAction
{
    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;

    /**
     * ListProjectAction constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function __invoke(ListCriteria $listCriteria)
    {
        return $this->projectRepository->listProjects($listCriteria);
    }

}
