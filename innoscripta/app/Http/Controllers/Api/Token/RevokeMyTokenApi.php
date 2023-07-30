<?php
namespace App\Http\Controllers\Api\Token;

use App\Actions\Token\RevokeTokenAction;
use App\Exceptions\Token\InvalidTokenException;
use App\Exceptions\Token\TokenNotFoundException;
use Illuminate\Http\Response;

/**
 * Logout API
 *
 * Class RevokeMyTokenApi
 * @package App\Http\Controllers\Api\Token
 */
class RevokeMyTokenApi
{
    /**
     * @var RevokeTokenAction
     */
    private RevokeTokenAction $revokeTokenAction;

    /**
     * RevokeTokenApi constructor.
     * @param RevokeTokenAction $revokeTokenAction
     */
    public function __construct(RevokeTokenAction $revokeTokenAction)
    {
        $this->revokeTokenAction = $revokeTokenAction;
    }

    /**
     * @return Response
     * @throws InvalidTokenException
     * @throws TokenNotFoundException
     */
    public function __invoke()
    {
        $request = request();
        $bearerToken = $request->header('Authorization');

        $this->revokeTokenAction->__invoke(explode(" ", $bearerToken)[1]);

        return response()->noContent();
    }

}
