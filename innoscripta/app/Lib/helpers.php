<?php

use App\Lib\Date\IntlDateTime;
use Illuminate\Support\Str;

if(!function_exists('is_json'))
{
    /**
     * @param string $json
     * @return bool
     */
    function is_json(string $json):bool
    {
        try {
            json_decode($json, false, 512, JSON_THROW_ON_ERROR);
            return true;
        } catch (JsonException $e) {
            return false;
        }
    }

}


if(!function_exists('rand_boolean'))
{
    /**
     * @return bool
     */
    function rand_boolean(): bool
    {
        return (rand(0,1) == 1);
    }
}

if(!function_exists('list_view_summary'))
{
    /**
     * @param string|null $text
     * @return bool
     */
    function list_view_summary(?string $text = null)
    {
        return !is_null($text) ? Str::limit($text, 50)."..." : "";
    }
}


if(!function_exists('get_user_ip'))
{
    /**
     * @return string
     */
    function get_user_ip(): string
    {
        $val = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
            $_SERVER['HTTP_X_FORWARDED_FOR'] :
            $_SERVER['REMOTE_ADDR'];

        return isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : $val;
    }
}

if(!function_exists('get_user_os')) {
    /**
     * @return string
     */
    function get_user_os(): string
    {
        $os_platform = "Unknown OS Platform";

        if(array_key_exists('HTTP_USER_AGENT', $_SERVER)) {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $os_array = array(
                '/windows nt 10/i' => 'Windows 10',
                '/windows nt 6.3/i' => 'Windows 8.1',
                '/windows nt 6.2/i' => 'Windows 8',
                '/windows nt 6.1/i' => 'Windows 7',
                '/windows nt 6.0/i' => 'Windows Vista',
                '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
                '/windows nt 5.1/i' => 'Windows XP',
                '/windows xp/i' => 'Windows XP',
                '/windows nt 5.0/i' => 'Windows 2000',
                '/windows me/i' => 'Windows ME',
                '/win98/i' => 'Windows 98',
                '/win95/i' => 'Windows 95',
                '/win16/i' => 'Windows 3.11',
                '/macintosh|mac os x/i' => 'Mac OS X',
                '/mac_powerpc/i' => 'Mac OS 9',
                '/linux/i' => 'Linux',
                '/ubuntu/i' => 'Ubuntu',
                '/iphone/i' => 'iPhone',
                '/ipod/i' => 'iPod',
                '/ipad/i' => 'iPad',
                '/android/i' => 'Android',
                '/blackberry/i' => 'BlackBerry',
                '/webos/i' => 'Mobile'
            );

            foreach ($os_array as $regex => $value)
                if (preg_match($regex, $user_agent))
                    $os_platform = $value;

            return $os_platform;
        }

        return $os_platform;
    }
}

if(!function_exists('randomString'))
{
    function randomString($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

if(!function_exists('get_array_fields')) {
    /**
     * @param array $data
     * @param array $keys
     * @return array
     */
    function get_array_fields(array $data, array $keys): array
    {
        $res = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $keys)) {
                $res[$key] = $value;
            }
        }

        return $res;
    }
}

if(!function_exists('parseText')) {

    /**
     * @param string $text
     * @param array $tokens
     * @return string
     */
    function parseText(string $text, array $tokens): string
    {
        foreach ($tokens as $key => $value) {
            $text = str_replace("{{".$key."}}", $value, $text);
        }

        return $text;
    }
}

if(!function_exists('get_month_jalali'))
{
    /**
     * @param int|null $timestamp
     * @return string
     * @throws Exception
     */
    function get_month_jalali(?int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();

        return (new IntlDateTime(
            $timestamp,
            'Asia/Tehran',
            'persian',
            'en_US'
        ))->format('MM');
    }
}

if(!function_exists('get_year_jalali'))
{
    /**
     * @param int|null $timestamp
     * @return string
     * @throws Exception
     */
    function get_year_jalali(?int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();

        return (new IntlDateTime(
            $timestamp,
            'Asia/Tehran',
            'persian',
            'en_US'
        ))->format('y');
    }
}

if(!function_exists('get_month_day_jalali'))
{
    /**
     * @param int|null $timestamp
     * @return string
     * @throws Exception
     */
    function get_month_day_jalali(?int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();

        return (new IntlDateTime(
            $timestamp,
            'Asia/Tehran',
            'persian',
            'en_US'
        ))->format('dd');
    }
}


if(!function_exists('get_week_jalali')) {

    /**
     * @param int|null $timestamp
     * @return string
     * @throws Exception
     */
    function get_week_jalali(?int $timestamp = null): string
    {
        $timestamp = $timestamp ?? time();

        return (new IntlDateTime(
            $timestamp,
            'Asia/Tehran',
            'persian',
            'en_US'
        ))->format('ww');
    }

}
