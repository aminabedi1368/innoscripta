<?php
namespace App\Http\Controllers\Api\Token;

use App\Actions\Token\GetMyProfileAction;

/**
 * Class GetMyProfileApi
 * @package App\Http\Controllers\Api\Token
 */
class GetMyProfileApi
{
    /**
     * @var GetMyProfileAction
     */
    private GetMyProfileAction $getMyProfileAction;

    /**
     * GetMyProfileApi constructor.
     * @param GetMyProfileAction $getMyProfileAction
     */
    public function __construct(GetMyProfileAction $getMyProfileAction)
    {
        $this->getMyProfileAction = $getMyProfileAction;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

}
