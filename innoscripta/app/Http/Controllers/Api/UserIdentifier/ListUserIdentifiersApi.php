<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\UserIdentifier\ListUserIdentifiersAction;
use App\Hydrators\UserIdentifierHydrator;
use App\Lib\ListView\ListCriteria;
use App\Lib\TokenInfoVO;

/**
 * Class ListUserIdentifiersApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class ListUserIdentifiersApi
{
    /**
     * @var ListUserIdentifiersAction
     */
    private ListUserIdentifiersAction $listUserIdentifiersAction;

    /**
     * @var UserIdentifierHydrator
     */
    private UserIdentifierHydrator $userIdentifierHydrator;

    /**
     * ListUserIdentifiersApi constructor.
     * @param ListUserIdentifiersAction $listUserIdentifiersAction
     * @param UserIdentifierHydrator $userIdentifierHydrator
     */
    public function __construct(
        ListUserIdentifiersAction $listUserIdentifiersAction,
        UserIdentifierHydrator $userIdentifierHydrator
    )
    {
        $this->listUserIdentifiersAction = $listUserIdentifiersAction;
        $this->userIdentifierHydrator = $userIdentifierHydrator;
    }

    /**
     * @param ListCriteria $listCriteria
     */
    public function __invoke()
    {
        /**
         * @var TokenInfoVO $tokenInfo
         */
        $tokenInfo = request('tokenInfo');

        $result = $this->listUserIdentifiersAction->__invoke($tokenInfo->getUserEntity());

        return response()->json(
            $this->userIdentifierHydrator->fromArrayOfEntities($result)->toArrayOfArrays()
        );
    }

}
