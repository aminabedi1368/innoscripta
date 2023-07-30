<?php
namespace App\Http\Controllers\Api\Project;

use App\Actions\Project\ListProjectAction;
use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use Illuminate\Http\JsonResponse;

/**
 * Class ListProjectApi
 * @package App\Http\Controllers\Api\Project
 */
class ListProjectApi
{

    /**
     * @var ListProjectAction
     */
    private ListProjectAction $listProjectAction;

    /**
     * ListProjectApi constructor.
     * @param ListProjectAction $listProjectAction
     */
    public function __construct(ListProjectAction $listProjectAction)
    {
        $this->listProjectAction = $listProjectAction;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke()
    {
        $listCriteria = ListCriteria::fromRequestStatic(request());

        $paginatedProjectEntities = $this->listProjectAction->__invoke($listCriteria);

        return $this->generateResponse($paginatedProjectEntities);
    }

    /**
     * @param PaginatedEntityList $paginatedEntityList
     * @return JsonResponse
     */
    private function generateResponse(PaginatedEntityList $paginatedEntityList)
    {
        if(request()->headers->has('X-Pagination')) {
            if($header = request()->header('X-Pagination')) {
                if($header === 'body') {
                    return response()->json($paginatedEntityList->toArray(true));
                }
            }
        }

        return response()->json(
            $paginatedEntityList->toArray(false),
            200,
            ['Content-Range' => $paginatedEntityList->getRange()]
        );
    }

}
