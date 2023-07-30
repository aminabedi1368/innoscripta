<?php
namespace App\Constants;

/**
 * Class ClientConstants
 * @package App\Constants
 */
final class ClientConstants
{

    const CLIENT_TYPE_BACKEND = 'backend';
    const CLIENT_TYPE_WEB = 'web';
    const CLIENT_TYPE_MOBILE = 'mobile';

    const OAUTH_TYPE_PUBLIC = 'public';
    const OAUTH_TYPE_CONFIDENTIAL = 'confidential';

    const OAUTH_CLIENT_TYPES = [
        self::OAUTH_TYPE_CONFIDENTIAL,
        self::OAUTH_TYPE_PUBLIC
    ];

    const ALL_TYPES = [
        self::CLIENT_TYPE_BACKEND,
        self::CLIENT_TYPE_MOBILE,
        self::CLIENT_TYPE_WEB
    ];

}
