<?php
namespace App\Validators;

use App\Constants\OAuthGrantTypes;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthValidator
 * @package App\Validators
 */
class AuthValidator
{
    /**
     * @var Factory
     */
    private Factory $validator;


    /**
     * ClientValidator constructor.
     * @param Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateGrantType(array $data)
    {
        $this->validator->validate($data, [
            'grant_type' => 'required|string|in:'.implode(',', OAuthGrantTypes::ALL_GRANT_TYPES)
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateIssueTokenPassword(array $data)
    {
        $this->validator->validate($data, [
            'grant_type' => 'required|string|in:'.OAuthGrantTypes::PASSWORD,
            'username' => 'required|string|min:6',
            'password' => 'required|string|min:6'
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateIssueTokenOtp(array $data)
    {
        $this->validator->validate($data, [
            'grant_type' => 'required|string|in:'.OAuthGrantTypes::OTP,
            'username' => 'required|string|min:6',
            'code' => 'required|string|size:5',
        ]);
    }


    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateIssueTokenClientCredentials(array $data)
    {
        $this->validator->validate($data, [
            'grant_type' => 'required|string|in:'.OAuthGrantTypes::CLIENT_CREDENTIALS,
            'client_id' => 'required|string|min:5',
            'client_secret' => 'required|string|min:5',
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateIssueTokenRefreshToken(array $data)
    {
        $this->validator->validate($data, [
            'grant_type' => 'required|string|in:'.OAuthGrantTypes::REFRESH_TOKEN,
            'refresh_token' => 'required|string|min:10'
        ]);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function validateIssueTokenAuthorizationCode(array $data)
    {
        $this->validator->validate($data, [
            'grant_type' => 'required|string|in:'.OAuthGrantTypes::AUTHORIZATION_CODE,
            'code' => 'required|string',
            'redirect_uri' => 'required|url'
        ]);
    }

}
