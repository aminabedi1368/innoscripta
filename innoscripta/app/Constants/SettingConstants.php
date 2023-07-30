<?php
namespace App\Constants;

/**
 * Class SettingConstants
 * @package App\Constants
 */
final class SettingConstants
{

    const KAVEHNEGAR_API_KEY = 'kavehnegar_api_key';
    const KAVEHNEGAR_SENDER_NUMBER = 'kavehnegar_sender_number';
    const KAVEHNEGAR_VERIFICATION_TEXT = 'kavehnegar_verification_text';
    const KAVEHNEGAR_VERIFICATION_TEMPLATE_NAME = 'kavehnegar_verification_template_name';

    const TWILIO_SID = 'TWILIO_SID';
    const TWILIO_TOKEN = 'TWILIO_TOKEN';
    const TWILIO_FROM = 'TWILIO_FROM';

    const OAUTH_ACCESS_TOKEN_EXPIRES_DAYS = 'oauth_access_token_expires_days';
    const OAUTH_REFRESH_TOKEN_EXPIRES_DAYS = 'oauth_refresh_token_expires_days';
    const OAUTH_ENCRYPTION_KEY = 'oauth_encryption_key';
    const OAUTH_PRIVATE_KEY = 'oauth_private_key';
    const OAUTH_PUBLIC_KEY = 'oauth_public_key';

    const IS_IDENTIFIER_EMAIL_ENABLED = 'available_identifier_email';
    const IS_IDENTIFIER_MOBILE_ENABLED = 'available_identifier_mobile';
    const IS_IDENTIFIER_USERNAME_ENABLED = 'available_identifier_username';


    const MAIL_SERVER_ADDRESS = "mail_server_address";
    const MAIL_SERVER_PORT = "mail_server_port";
    const MAIL_SERVER_USERNAME = "mail_server_username";
    const MAIL_SERVER_PASSWORD = "mail_server_password";

    const MAIL_VERIFICATION_FROM_ADDRESS = "mail_verification_from_address";
    const MAIL_VERIFICATION_FROM_NAME = "mail_verification_from_name";
    const MAIL_VERIFICATION_SUBJECT = "mail_verification_subject";
    const MAIL_VERIFICATION_TEMPLATE = "mail_verification_template";
    const MAIL_SERVER_TIMEOUT_SECONDS = "mail_server_timeout_in_seconds";


    const OTP_EXPIRE_IN_MINUTES = "otp_expires_in_minutes";
    const WEBSITE_URL = "website_url";
    const CLIENT_TOKEN_EXPIRES_DAYS = "client_token_expires_days";
    const OAUTH_GOOGLE_REDIRECT_OUR_OAUTH_TO_APPLICATION = "oauth_google_redirect_url";
    const OAUTH_GOOGLE_CLIENT_ID = "oauth_google_client_id";
    const OAUTH_GOOGLE_CLIENT_SECRET = "oauth_google_client_secret";
    const OAUTH_GOOGLE_REDIRECT_TO_OUR_OAUTH = "oauth_google_redirect";

}
