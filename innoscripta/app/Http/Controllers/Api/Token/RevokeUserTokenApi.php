<?php
namespace App\Http\Controllers\Api\Token;

use App\Actions\Token\RevokeTokenAction;
use App\Exceptions\Token\InvalidTokenException;
use App\Exceptions\Token\TokenNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Revoke User Token
 *
 * Class RevokeUserTokenApi
 * @package App\Http\Controllers\Api\Token
 */
class RevokeUserTokenApi
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
     * @param string $access_token
     * @return JsonResponse|Response
     */
    public function __invoke(string $access_token)
    {
        try {
            $this->revokeTokenAction->__invoke($access_token);
            return response()->noContent();
        }
        catch (InvalidTokenException|TokenNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'token not found'
            ], 404);
        }

    }

}
