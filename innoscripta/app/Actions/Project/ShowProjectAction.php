<?php
namespace App\Actions\Project;

use App\Entities\ProjectEntity;
use App\Repos\ProjectRepository;

/**
 * Class ShowProjectAction
 * @package App\Actions\Project
 */
class ShowProjectAction
{

    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;

    /**
     * ShowProjectAction constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param int $project_id
     * @param array $with
     * @return ProjectEntity
     */
    public function __invoke(int $project_id, array $with = [])
    {
        return $this->projectRepository->findProjectById($project_id, $with, true);
    }

}
