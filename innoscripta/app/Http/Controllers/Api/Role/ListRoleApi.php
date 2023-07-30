<?php
namespace App\Http\Controllers\Api\Role;

use App\Actions\Role\ListRoleAction;
use App\Exceptions\CorruptedDataException;
use App\Lib\ListView\ListCriteria;
use Illuminate\Http\JsonResponse;

/**
 * Class ListRoleApi
 * @package App\Http\Controllers\Api
 */
class ListRoleApi
{
    /**
     * @var ListRoleAction
     */
    private ListRoleAction $listRoleAction;

    /**
     * ListRolesApi constructor.
     * @param ListRoleAction $listRoleAction
     */
    public function __construct(ListRoleAction $listRoleAction)
    {
        $this->listRoleAction = $listRoleAction;
    }

    /**
     * @return JsonResponse
     * @throws CorruptedDataException
     */
    public function __invoke(): JsonResponse
    {
        $paginatedRoles = $this->listRoleAction->__invoke(
            ListCriteria::fromRequestStatic(request())
        );

        return response()->json(
            $paginatedRoles->toArray(),
            200,
            ['Content-Range' => $paginatedRoles->getRange()]
        );
//        return response()->json($paginatedRoles->toArray());
    }


}
