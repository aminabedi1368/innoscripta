<?php
namespace App\Http\Controllers\Api\Project;

use App\Actions\Project\UpdateProjectAction;

/**
 * Class UpdateProjectApi
 * @package App\Http\Controllers\Api\Project
 */
class UpdateProjectApi
{
    /**
     * @var UpdateProjectAction
     */
    private UpdateProjectAction $updateProjectAction;

    /**
     * UpdateProjectApi constructor.
     * @param UpdateProjectAction $updateProjectAction
     */
    public function __construct(UpdateProjectAction $updateProjectAction)
    {
        $this->updateProjectAction = $updateProjectAction;
    }


    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

}
