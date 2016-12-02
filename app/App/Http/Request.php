<?php

namespace App\Http;

/**
 * Request class processes HTTP request
 */
class Request {

    private static $requestMethod;

    /**
     * Check request method
     * @param  string $request request method name
     * @return boolean         request method set?
     */
    public static function check($requestMethod = 'POST')
    {
        self::$requestMethod = strtoupper($requestMethod);

        switch (self::$requestMethod) {
            case 'GET':
                return !empty($_GET) ? true : false;
                break;
            case 'POST':
                return !empty($_POST) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Return a single requested item value
     * @param  string $item requested item name
     * @return string       requested imem value
     */
    public static function getValue($item)
    {
        switch (self::$requestMethod) {
            case 'GET':
                return isset($_GET[$item]) ? $_GET[$item] : '';
                break;
            case 'POST':
                return isset($_POST[$item]) ? $_POST[$item] : '';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * Get all of request method contents
     * @return array request method contents
     */
    public static function get()
    {
        switch (self::$requestMethod) {
            case 'GET':
                return $_GET;
                break;
            case 'POST':
                return $_POST;
                break;
            default:
                return [];
                break;
        }
    }

    // CHECK
    public static function file()
    {
        return $_FILES;
    }
}
