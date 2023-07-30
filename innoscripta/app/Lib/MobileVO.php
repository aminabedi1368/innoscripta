<?php
namespace App\Lib;

use App\Exceptions\InvalidMobileFormatException;
use Illuminate\Support\Str;

/**
 * Class MobileVO
 * @package App\Lib
 */
final class MobileVO
{
    /**
     * @var string
     */
    protected string $code;

    /**
     * @var string
     */
    protected string $number;


    const WithZero = 1;

    const WithoutZero = 2;

    const WithCode = 3;


    /**
     * MobilePhone constructor.
     * @param $number
     * @param string $code
     * @throws InvalidMobileFormatException
     */
    public function __construct($number, $code = '+98')
    {
        $number = static::isValid($number);

        $this->number = $number;
        $this->code = $code;
    }


    /**
     * @param $number
     * @return string
     * @throws InvalidMobileFormatException
     */
    public static function isValid($number)
    {
        if (Str::startsWith($number, '0')) {

            if ($length = strlen($number) != 11) {
                throw new InvalidMobileFormatException(sprintf('mobile number which starts with zero
                should have 11 characters, given mobile has %s numbers of characters', $length));
            }

            if (!in_array(substr($number, 2, 1), ['0', '1', '2', '3', '9'])) {
                throw new InvalidMobileFormatException(sprintf('Third part of mobile number should be 0,1,2, 3 or 9, given %s', substr($number, 2, 1)));
            }
            $number = ltrim($number, 0);
        } elseif (Str::startsWith($number, '+98') || Str::startsWith($number, '098')) {
            $number = substr($number, 3, strlen($number) - 3);
        } elseif (Str::startsWith($number, '98')) {
            $number = substr($number, 2, strlen($number) - 2);
        } else {
            if ($length = strlen($number) != 10) {

                throw new InvalidMobileFormatException(sprintf('mobile number which starts with zero
                should have 10 characters, given mobile has %s numbers of characters', $length));
            }
        }

        return $number;
    }

    /**
     * @param $format
     * @return string
     * @throws InvalidMobileFormatException
     */
    public function format($format)
    {
        switch ($format) {
            case self::WithZero:
                $result = '0' . $this->number;
                break;

            case self::WithoutZero:
                $result = $this->number;
                break;


            case self::WithCode:
                $result = $this->code . $this->number;
                break;

            default:
                throw new InvalidMobileFormatException;
        }

        return $result;
    }


    /**
     * @param bool $associative
     * @return array
     */
    public function toArray($associative = true)
    {
        if ($associative) {
            $arrayPresentation = [
                'code' => $this->code,
                'number' => $this->number
            ];
        } else {
            $arrayPresentation = [
                $this->code,
                $this->number
            ];
        }


        return $arrayPresentation;
    }

    /**
     * @return string
     */
    public function preview()
    {
        return '0' . $this->number;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code . $this->number;
    }


    /**
     * @param MobileVO $valueObject
     * @return boolean
     */
    function isEqual(MobileVO $valueObject)
    {
        if (!$valueObject instanceof self) {
            return false;
        }

        return ($this->__toString() == $valueObject->__toString());
    }

    /**
     * @param $value
     * @return static
     */
    public static function fromOptions($value)
    {
        if (!empty($value)) {
            return new static($value);
        }
        return null;
    }


    /**
     * @return bool
     * @throws InvalidMobileFormatException
     */
    public function isMCI()
    {
        $number = $this->format(self::WithoutZero);

        $firstThreeChars = substr($number, 0, 3);

        if (in_array(
            $firstThreeChars,
            ['910', '911', '912', '913', '914', '915', '916', '917', '918', '919', '990', '991']
        )) {
            return true;
        }

        return false;
    }


    /**
     * @return bool
     * @throws InvalidMobileFormatException
     */
    function isMTN()
    {
        $number = $this->format(self::WithoutZero);

        $firstThreeChars = substr($number, 0, 3);

        if (in_array(
            $firstThreeChars,
            ['901', '902', '903', '933', '935', '936', '937', '938', '939']
        )) {
            return true;
        }

        return false;
    }

}
