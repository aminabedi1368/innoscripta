<?php
namespace App\Http\Controllers\Api\Token;

use App\Actions\Token\IssueTokenClientCredentialsAction;
use App\Actions\Token\IssueTokenOTPAction;
use App\Actions\Token\IssueTokenPasswordAction;
use App\Actions\Token\IssueTokenRefreshTokenAction;
use App\Constants\OAuthGrantTypes;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Validators\AuthValidator;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;

/**
 * Class IssueTokenApi
 * @package App\Http\Controllers\Api\Token
 */
class IssueTokenApi
{
    /**
     * @var IssueTokenOTPAction
     */
    private IssueTokenOTPAction $issueTokenOTPAction;

    /**
     * @var IssueTokenPasswordAction
     */
    private IssueTokenPasswordAction $issueTokenPasswordAction;

    /**
     * @var AuthValidator
     */
    private AuthValidator $authValidator;

    /**
     * @var IssueTokenRefreshTokenAction
     */
    private IssueTokenRefreshTokenAction $issueTokenRefreshTokenAction;

    /**
     * @var IssueTokenClientCredentialsAction
     */
    private IssueTokenClientCredentialsAction $issueTokenClientCredentialsAction;


    /**
     * IssueTokenApi constructor.
     * @param AuthValidator $authValidator
     * @param IssueTokenOTPAction $issueTokenOTPAction
     * @param IssueTokenPasswordAction $issueTokenPasswordAction
     * @param IssueTokenRefreshTokenAction $issueTokenRefreshTokenAction
     * @param IssueTokenClientCredentialsAction $issueTokenClientCredentialsAction
     */
    public function __construct(
        AuthValidator $authValidator,
        IssueTokenOTPAction $issueTokenOTPAction,
        IssueTokenPasswordAction $issueTokenPasswordAction,
        IssueTokenRefreshTokenAction $issueTokenRefreshTokenAction,
        IssueTokenClientCredentialsAction $issueTokenClientCredentialsAction
    )
    {
        $this->issueTokenOTPAction = $issueTokenOTPAction;
        $this->issueTokenPasswordAction = $issueTokenPasswordAction;
        $this->authValidator = $authValidator;
        $this->issueTokenRefreshTokenAction = $issueTokenRefreshTokenAction;
        $this->issueTokenClientCredentialsAction = $issueTokenClientCredentialsAction;
    }

    /**
     * @throws InvalidUserCredentialsException
     * @throws OAuthServerException
     * @throws ValidationException
     */
    public function __invoke()
    {
        $this->validate(request()->all());

        $action = $this->detectAction(request('grant_type'));

        return response()->json($action(request()));
    }


    /**
     * @param string $grant_type
     * @return IssueTokenOTPAction|IssueTokenPasswordAction|IssueTokenRefreshTokenAction|IssueTokenClientCredentialsAction
     */
    private function detectAction(string $grant_type)
    {
        if($grant_type === OAuthGrantTypes::CLIENT_CREDENTIALS) {
            return $this->issueTokenClientCredentialsAction;
        }
        elseif ($grant_type === OAuthGrantTypes::PASSWORD) {
            return $this->issueTokenPasswordAction;
        }
        elseif ($grant_type === OAuthGrantTypes::OTP) {
            return $this->issueTokenOTPAction;
        }
        elseif ($grant_type === OAuthGrantTypes::REFRESH_TOKEN) {
            return $this->issueTokenRefreshTokenAction;
        }
        elseif ($grant_type === OAuthGrantTypes::AUTHORIZATION_CODE) {

        }
    }


    /**
     * @param array $data
     * @throws ValidationException
     */
    private function validate(array $data)
    {
        if(
            !request()->has('grant_type') ||
            !in_array(request()->get('grant_type'), OAuthGrantTypes::ALL_GRANT_TYPES)
        ) {
            $this->authValidator->validateGrantType($data);
        }
        elseif (request()->get('grant_type') === OAuthGrantTypes::AUTHORIZATION_CODE) {
            $this->authValidator->validateIssueTokenAuthorizationCode($data);
        }

        elseif (request()->get('grant_type') === OAuthGrantTypes::PASSWORD) {
            $this->authValidator->validateIssueTokenPassword($data);
        }

        elseif (request()->get('grant_type') === OAuthGrantTypes::OTP) {
            $this->authValidator->validateIssueTokenOtp($data);
        }

        elseif (request()->get('grant_type') === OAuthGrantTypes::REFRESH_TOKEN) {
            $this->authValidator->validateIssueTokenRefreshToken($data);
        }

        elseif (request()->get('grant_type') === OAuthGrantTypes::CLIENT_CREDENTIALS) {
            $this->authValidator->validateIssueTokenClientCredentials($data);
        }

    }

}
