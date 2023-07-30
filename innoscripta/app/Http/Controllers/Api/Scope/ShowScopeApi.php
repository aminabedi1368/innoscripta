<?php
namespace App\Http\Controllers\Api\Scope;

use App\Actions\Scope\ShowScopeAction;

/**
 * Class ShowScopeApi
 * @package App\Http\Controllers\Api\Scope
 */
class ShowScopeApi
{
    /**
     * @var ShowScopeAction
     */
    private ShowScopeAction $showScopeAction;

    /**
     * ShowScopeApi constructor.
     * @param ShowScopeAction $showScopeAction
     */
    public function __construct(ShowScopeAction $showScopeAction)
    {
        $this->showScopeAction = $showScopeAction;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}
