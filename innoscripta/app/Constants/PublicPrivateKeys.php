<?php
namespace App\Constants;

/**
 * Class PublicPrivateKeys
 * @package App\Constants
 */
final class PublicPrivateKeys
{

    const DIGEST_ALG_SHA256 = "sha256";
    const DIGEST_ALG_SHA512 = "sha512";
    const DIGEST_ALG_SHA1 = "sha1";

    const ALL_DIGEST_ALG = [
        self::DIGEST_ALG_SHA256,
        self::DIGEST_ALG_SHA512,
        self::DIGEST_ALG_SHA1
    ];

    const PRIVATE_KEY_BITS_1024 = 1024;
    const PRIVATE_KEY_BITS_2048 = 2048;
    const PRIVATE_KEY_BITS_4096 = 4096;

    const ALL_PRIVATE_KEY_BITS = [
        self::PRIVATE_KEY_BITS_1024,
        self::PRIVATE_KEY_BITS_2048,
        self::PRIVATE_KEY_BITS_4096
    ];

}
