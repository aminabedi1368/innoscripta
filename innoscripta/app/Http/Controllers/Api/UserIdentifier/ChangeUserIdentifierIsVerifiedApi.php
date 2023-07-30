<?php
namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\UserIdentifier\ChangeUserIdentifierIsVerifiedAction;

/**
 * Class ChangeUserIdentifierIsVerifiedApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class ChangeUserIdentifierIsVerifiedApi
{

    /**
     * @var ChangeUserIdentifierIsVerifiedAction
     */
    private ChangeUserIdentifierIsVerifiedAction $changeUserIdentifierIsVerifiedAction;

    /**
     * ChangeUserIdentifierIsVerifiedApi constructor.
     * @param ChangeUserIdentifierIsVerifiedAction $changeUserIdentifierIsVerifiedAction
     */
    public function __construct(ChangeUserIdentifierIsVerifiedAction $changeUserIdentifierIsVerifiedAction)
    {
        $this->changeUserIdentifierIsVerifiedAction = $changeUserIdentifierIsVerifiedAction;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

}
