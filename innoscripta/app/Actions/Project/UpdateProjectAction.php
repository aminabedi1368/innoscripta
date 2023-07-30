<?php
namespace App\Actions\Project;

use App\Entities\ProjectEntity;
use App\Repos\ProjectRepository;

/**
 * Class UpdateProjectAction
 * @package App\Actions\Project
 */
class UpdateProjectAction
{

    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;

    /**
     * UpdateProjectAction constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param ProjectEntity $projectEntity
     */
    public function __invoke(ProjectEntity $projectEntity)
    {
        // TODO: Implement __invoke() method.
    }

}
