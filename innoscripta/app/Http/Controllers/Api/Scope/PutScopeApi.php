<?php
namespace App\Http\Controllers\Api\Scope;

use App\Actions\Scope\PutScopeAction;

/**
 * Class PutScopeApi
 * @package App\Http\Controllers\Api\Scope
 */
class PutScopeApi
{
    /**
     * @var PutScopeAction
     */
    private PutScopeAction $updateScopeAction;

    /**
     * UpdateScopeApi constructor.
     * @param PutScopeAction $updateScopeAction
     */
    public function __construct(PutScopeAction $updateScopeAction)
    {
        $this->updateScopeAction = $updateScopeAction;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

}
