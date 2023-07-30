<?php
namespace App\Http\Controllers\Api\Project;

use App\Actions\Project\ShowProjectAction;
use App\Hydrators\ProjectHydrator;
use Illuminate\Http\JsonResponse;

/**
 * Class ShowProjectApi
 * @package App\Http\Controllers\Api\Project
 */
class ShowProjectApi
{
    /**
     * @var ShowProjectAction
     */
    private ShowProjectAction $showProjectAction;
    /**
     * @var ProjectHydrator
     */
    private ProjectHydrator $projectHydrator;


    /**
     * ShowProjectApi constructor.
     * @param ShowProjectAction $showProjectAction
     * @param ProjectHydrator $projectHydrator
     */
    public function __construct(ShowProjectAction $showProjectAction, ProjectHydrator $projectHydrator)
    {
        $this->showProjectAction = $showProjectAction;
        $this->projectHydrator = $projectHydrator;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id)
    {
        $projectEntity = $this->showProjectAction->__invoke($id, ['scopes', 'clients', 'roles', 'creatorUser']);

        return response()->json($this->projectHydrator->fromEntity($projectEntity)->toArray());
    }

}
