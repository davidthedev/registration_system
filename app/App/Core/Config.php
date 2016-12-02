<?php

namespace App\Core;

use Exception;

/**
 * Config class gets application configuration settings
 * from config.dev.php file
 */
class Config {

    public static function get($key)
    {
        $config = __DIR__ . '/../Config/config.dev.php';
        $config = require $config;
        return $config[$key];
    }
}
