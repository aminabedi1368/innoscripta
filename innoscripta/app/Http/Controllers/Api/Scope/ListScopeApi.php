<?php
namespace App\Http\Controllers\Api\Scope;

use App\Actions\Scope\ListScopeAction;
use App\Lib\ListView\ListCriteria;
use Illuminate\Http\JsonResponse;

/**
 * Class ListScopeApi
 * @package App\Http\Controllers\Api\Scope
 */
class ListScopeApi
{
    /**
     * @var ListScopeAction
     */
    private ListScopeAction $listScopeAction;

    /**
     * ListScopeApi constructor.
     * @param ListScopeAction $listScopeAction
     */
    public function __construct(ListScopeAction $listScopeAction)
    {
        $this->listScopeAction = $listScopeAction;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $paginatedRoles = $this->listScopeAction->__invoke(
            ListCriteria::fromRequestStatic(request())
        );

        return response()->json(
            $paginatedRoles->toArray(),
            200,
            ['Content-Range' => $paginatedRoles->getRange()]
        );

//        return response()->json($paginatedRoles->toArray());    }

    }

}
