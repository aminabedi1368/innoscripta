<?php
namespace App\Constants;

/**
 * Class UserIdentifierType
 * @package App\Constants
 */
class UserIdentifierType
{

    const EMAIL = 'email';
    const MOBILE = 'mobile';
    const NATIONAL_CODE = 'national_code';

    const ALL_TYPES = [
        self::MOBILE,
        self::EMAIL,
        self::NATIONAL_CODE
    ];

}
