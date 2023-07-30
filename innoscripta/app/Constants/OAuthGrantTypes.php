<?php
namespace App\Constants;

/**
 * Class OAuthGrantTypes
 * @package App\Constants
 */
final class OAuthGrantTypes
{

    const PASSWORD = 'password';
    const AUTHORIZATION_CODE = 'authorization_code';
    const CLIENT_CREDENTIALS = 'client_credentials';
    const REFRESH_TOKEN = 'refresh_token';
    const OTP = 'otp';


    const ALL_GRANT_TYPES = [
        self::PASSWORD,
        self::AUTHORIZATION_CODE,
        self::CLIENT_CREDENTIALS,
        self::REFRESH_TOKEN,
        self::OTP
    ];

}
