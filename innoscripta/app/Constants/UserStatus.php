<?php
namespace App\Constants;

/**
 * Class UserStatus
 * @package App\Constants
 */
final class UserStatus
{

    const ACTIVE = 'active';
    const LOCKED = 'locked';

    const ALL_STATUS = [
        self::ACTIVE,
        self::LOCKED
    ];

}
