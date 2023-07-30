<?php
namespace App\Exceptions;

use Throwable;

/**
 * Class SettingKeyNotFoundAnyWhereException
 * @package App\Exceptions
 */
class SettingKeyNotFoundAnyWhereException extends \Exception
{

    public function __construct($key , $code = 0, Throwable $previous = null)
    {
        parent::__construct("Setting key : $key not found", $code, $previous);
    }

}
