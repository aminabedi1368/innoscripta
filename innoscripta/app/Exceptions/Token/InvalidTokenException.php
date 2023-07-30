<?php
namespace App\Exceptions\Token;

use Throwable;

/**
 * Class InvalidTokenException
 * @package App\Exceptions
 */
class InvalidTokenException extends \Exception
{

    /**
     * InvalidTokenException constructor.
     * @param string $access_token
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $access_token , $code = 0, Throwable $previous = null)
    {
        parent::__construct("Token: $access_token is invalid", $code, $previous);
    }

}
