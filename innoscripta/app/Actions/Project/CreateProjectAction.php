<?php
namespace App\Actions\Project;

use App\Entities\ProjectEntity;
use App\Repos\ProjectRepository;

/**
 * Class CreateProjectAction
 * @package App\Actions\Project
 */
class CreateProjectAction
{

    /**
     * @var ProjectRepository
     */
    private ProjectRepository $projectRepository;


    /**
     * CreateProjectAction constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }


    /**
     * @param ProjectEntity $projectEntity
     * @return ProjectEntity
     */
    public function __invoke(ProjectEntity $projectEntity)
    {
        $projectEntity->setProjectId($this->generateProjectIdString());

        return $this->projectRepository->createProject($projectEntity);
    }

    /**
     * @return string
     */
    private function generateProjectIdString()
    {
        return $this->generateRandomString(15);
    }

    /**
     * @param int $length
     * @return string
     */
    private function  generateRandomString(int $length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
