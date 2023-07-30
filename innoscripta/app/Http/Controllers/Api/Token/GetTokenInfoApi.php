<?php
namespace App\Http\Controllers\Api\Token;

use App\Actions\Token\GetTokenInfoAction;
use App\Exceptions\Token\InvalidTokenException;
use Illuminate\Http\JsonResponse;

/**
 * Class GetTokenInfoApi
 * @package App\Http\Controllers\Api\Token
 */
class GetTokenInfoApi
{
    /**
     * @var GetTokenInfoAction
     */
    private GetTokenInfoAction $getTokenInfoAction;

    /**
     * GetTokenInfoApi constructor.
     * @param GetTokenInfoAction $getTokenInfoAction
     */
    public function __construct(GetTokenInfoAction $getTokenInfoAction)
    {
        $this->getTokenInfoAction = $getTokenInfoAction;
    }

    /**
     * @param string $access_token
     * @return JsonResponse
     */
    public function __invoke(string $access_token): JsonResponse
    {
        try{
            $tokenInfo = $this->getTokenInfoAction->__invoke($access_token);
            return response()->json($tokenInfo->toArray());
        }
        catch (InvalidTokenException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'access token not found'
            ], 404);
        }

    }

}
