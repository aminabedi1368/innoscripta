<?php
namespace App\Http\Controllers\Api\User;

use App\Actions\User\ListUsersAction;
use App\Exceptions\CorruptedDataException;
use App\Lib\ListView\ListCriteria;
use Illuminate\Http\JsonResponse;

/**
 * Class ListUserApi
 * @package App\Http\Controllers\Api\User
 */
class ListUserApi
{
    /**
     * @var ListUsersAction
     */
    private ListUsersAction $listUsersAction;

    /**
     * ListUserApi constructor.
     * @param ListUsersAction $listUsersAction
     */
    public function __construct(ListUsersAction $listUsersAction)
    {
        $this->listUsersAction = $listUsersAction;
    }

    /**
     * @param ListCriteria $listCriteria
     * @return JsonResponse
     * @throws CorruptedDataException
     */
    public function __invoke(ListCriteria $listCriteria): JsonResponse
    {
        $usersList = $this->listUsersAction->__invoke($listCriteria, request('search'));

        return response()->json($usersList->toArray());
    }

}
