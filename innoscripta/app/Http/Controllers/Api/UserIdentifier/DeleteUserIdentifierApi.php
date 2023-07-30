<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\UserIdentifier\RemoveUserIdentifierAction;

/**
 * Class DeleteUserIdentifierApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class DeleteUserIdentifierApi
{
    /**
     * @var RemoveUserIdentifierAction
     */
    private RemoveUserIdentifierAction $removeUserIdentifierAction;

    /**
     * DeleteUserIdentifierApi constructor.
     * @param RemoveUserIdentifierAction $removeUserIdentifierAction
     */
    public function __construct(RemoveUserIdentifierAction $removeUserIdentifierAction)
    {
        $this->removeUserIdentifierAction = $removeUserIdentifierAction;
    }

    /**
     * @param integer $id
     * @return Response
     */
    public function __invoke(int $id)
    {
        $this->removeUserIdentifierAction->__invoke($id);

        return response()->noContent();
    }

}
