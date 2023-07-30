<?php

namespace App\Http\Controllers\Api\UserIdentifier;

use App\Actions\Token\IssueTokenAdminAction;
use App\Actions\UserIdentifier\VerifyUserIdentifierAction;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Exceptions\CorruptedDataException;
use App\Exceptions\UserIdentifier\InvalidVerificationCodeException;
use App\Exceptions\UserIdentifier\UserIdentifierAlreadyVerifiedException;
use App\Models\ClientModel;
use App\Validators\UserIdentifierValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Illuminate\Http\Request;

/**
 * Class VerifyUserIdentifierApi
 * @package App\Http\Controllers\Api\UserIdentifier
 */
class VerifyUserIdentifierApi
{
    /**
     * @var VerifyUserIdentifierAction
     */
    private VerifyUserIdentifierAction $verifyUserIdentifierAction;

    /**
     * @var IssueTokenAdminAction
     */
    private IssueTokenAdminAction $issueTokenAdminAction;

    /**
     * @var UserIdentifierValidator
     */
    private UserIdentifierValidator $userIdentifierValidator;


    /**
     * VerifyUserIdentifierApi constructor.
     * @param VerifyUserIdentifierAction $verifyUserIdentifierAction
     * @param IssueTokenAdminAction $issueTokenAdminAction
     * @param UserIdentifierValidator $userIdentifierValidator
     */
    public function __construct(
        VerifyUserIdentifierAction $verifyUserIdentifierAction,
        IssueTokenAdminAction      $issueTokenAdminAction,
        UserIdentifierValidator    $userIdentifierValidator
    )
    {
        $this->verifyUserIdentifierAction = $verifyUserIdentifierAction;
        $this->issueTokenAdminAction = $issueTokenAdminAction;
        $this->userIdentifierValidator = $userIdentifierValidator;
    }


    /**
     * @return JsonResponse
     * @throws CorruptedDataException
     * @throws InvalidUserCredentialsException
     * @throws InvalidVerificationCodeException
     * @throws OAuthServerException
     * @throws UserIdentifierAlreadyVerifiedException
     * @throws ValidationException
     */
    public function __invoke()
    {
        $this->userIdentifierValidator->validateVerifyUserIdentifier(request()->only('type', 'value', 'code'));
        $this->verifyUserIdentifierAction->__invoke(
            request('type'),
            request('value'),
            request('code'),
        );

        $request = request();

        /** @var ClientModel $client */
        $client = ClientModel::query()->firstOrFail();

        $user_array = [
            'username' => request('value'),
            'grant_type' => 'admin_generate_token',
            'client_id' => $client->client_id,
            'client_secret' => $client->client_secret,
        ];

        $newRequest = new Request(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            json_encode($user_array)
        );

        return response()->json($this->issueTokenAdminAction->__invoke($newRequest));
    }

}
