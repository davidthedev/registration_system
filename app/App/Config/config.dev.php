<?php

/**
 * Application settings
 */
return [
    // url
    'URL' => 'http://' . dirname($_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']) . '/',
    'CURRENT_URL' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
    'BASE_URL' => 'http://' . $_SERVER['SERVER_NAME']  .
        dirname(dirname($_SERVER['PHP_SELF'])) . '/storage/',
    // directory
    'INCLUDES' => dirname(__DIR__) . '/View/Includes',
    'VIEWS' => dirname(__DIR__) . '/View/',
    'BASE_DIR' => realpath(dirname(__FILE__) . '/../../'),
    'PUBLIC_DIR' => realpath(dirname(__FILE__) . '/../../../public'),
    'FILE_STORAGE' => realpath(dirname(__FILE__) . '/../../../storage'),
    // database
    'DB_DRIVER' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'login_app',
    'DB_USERNAME' => 'root', // change to your database username
    'DB_PASSWORD' => 'root', // change to your database password
    // session
    'SESSION_NAME' => 'user',
    'CSRF_TOKEN_NAME' => 'zUVLEdsniA'
];
