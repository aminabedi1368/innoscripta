<?php
namespace App\Http\Controllers\Api\Client;

use App\Actions\Client\ListClientByProjectAction;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Hydrators\ProjectHydrator;
use Illuminate\Http\JsonResponse;

/**
 * Class ListClientByProjectApi
 * @package App\Http\Controllers\Api\Client
 */
class ListClientByProjectApi
{
    /**
     * @var ListClientByProjectAction
     */
    private ListClientByProjectAction $listClientByProjectAction;

    /**
     * @var ProjectHydrator
     */
    private ProjectHydrator $projectHydrator;

    /**
     * ListClientApi constructor.
     * @param ListClientByProjectAction $listClientByProjectAction
     * @param ProjectHydrator $projectHydrator
     */
    public function __construct(ListClientByProjectAction $listClientByProjectAction, ProjectHydrator $projectHydrator)
    {
        $this->listClientByProjectAction = $listClientByProjectAction;
        $this->projectHydrator = $projectHydrator;
    }


    /**
     * @param string $project_slug
     * @return JsonResponse
     * @throws InvalidUserCredentialsException
     */
    public function __invoke(string $project_slug): JsonResponse
    {
        if(request()->header('Authorization') != env('admin_server_token') ) {
            throw new InvalidUserCredentialsException;
        }

        $projectArray = $this->projectHydrator->fromEntity(
            $this->listClientByProjectAction->__invoke($project_slug)
        )->toArray();

        return response()->json(array_key_exists('clients', $projectArray) ? $projectArray['clients'] : []);
    }

}
