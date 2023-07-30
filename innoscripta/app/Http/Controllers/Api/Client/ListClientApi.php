<?php
namespace App\Http\Controllers\Api\Client;

use App\Actions\Client\ListClientAction;
use App\Lib\ListView\ListCriteria;
use Illuminate\Http\JsonResponse;

/**
 * Class ListClientApi
 * @package App\Http\Controllers\Api\Client
 */
class ListClientApi
{
    /**
     * @var ListClientAction
     */
    private ListClientAction $listClientAction;

    /**
     * ListClientApi constructor.
     * @param ListClientAction $listClientAction
     */
    public function __construct(ListClientAction $listClientAction)
    {
        $this->listClientAction = $listClientAction;
    }


    /**
     * @return JsonResponse
     */
    public function __invoke()
    {
        $listCriteria = ListCriteria::fromRequestStatic(request());

        $paginated = false;
        if(request('paginated') ) {
            $paginated = true;
        }

        return response()->json(
            $this->listClientAction->__invoke($listCriteria)->toArray($paginated)
        );
    }

}
