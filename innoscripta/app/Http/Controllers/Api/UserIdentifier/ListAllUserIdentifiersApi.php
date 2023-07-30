<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\UserIdentifier\ListAllUserIdentifiersAction;
use App\Actions\UserIdentifier\ListUserIdentifiersAction;
use App\Lib\ListView\ListCriteria;

/**
 * Class ListAllUserIdentifiersApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class ListAllUserIdentifiersApi
{
    /**
     * @var ListAllUserIdentifiersAction
     */
    private ListAllUserIdentifiersAction $listAllUserIdentifiersAction;

    /**
     * ListUserIdentifiersApi constructor.
     * @param ListAllUserIdentifiersAction $listAllUserIdentifiersAction
     */
    public function __construct(ListAllUserIdentifiersAction $listAllUserIdentifiersAction)
    {
        $this->listAllUserIdentifiersAction = $listAllUserIdentifiersAction;
    }

    /**
     * @param ListCriteria $listCriteria
     */
    public function __invoke(ListCriteria $listCriteria)
    {
        $result = $this->listAllUserIdentifiersAction->__invoke($listCriteria);

        return response()->json($result->toArray());
    }

}
