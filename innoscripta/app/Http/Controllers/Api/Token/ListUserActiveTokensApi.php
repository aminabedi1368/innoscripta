<?php
namespace App\Http\Controllers\Api\Token;

use App\Actions\Token\ListUserActiveTokensAction;

/**
 * Class ListUserActiveTokensApi
 * @package App\Http\Controllers\Api\Token
 */
class ListUserActiveTokensApi
{
    /**
     * @var ListUserActiveTokensAction
     */
    private ListUserActiveTokensAction $listUserActiveTokensAction;

    /**
     * ListUserActiveTokensApi constructor.
     * @param ListUserActiveTokensAction $listUserActiveTokensAction
     */
    public function __construct(ListUserActiveTokensAction $listUserActiveTokensAction)
    {
        $this->listUserActiveTokensAction = $listUserActiveTokensAction;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

}
