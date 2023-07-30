<?php
namespace App\Actions\Project;

use App\Repos\ProjectRepository;

/**
 * Class DeleteProjectAction
 * @package App\Actions\Project
 */
class DeleteProjectAction
{

    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;

    /**
     * DeleteProjectAction constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function __invoke(int $id)
    {
        return $this->projectRepository->deleteById($id);
    }

}
