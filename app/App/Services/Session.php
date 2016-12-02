<?php

namespace App\Services;

use App\Config;

/**
 * Session class deals with all session data. Essential, this class is
 * just an abstraction of native sesison management encaplusated in a class.
 */
class Session {

    /**
     * Start / initialize a new session
     * @return void
     */
    public function start()
    {
        session_start();
    }

    /**
     * Check if session variable exists,
     * if it does return session value
     * @param  string $name session name
     * @return bool /string false if session does not exist
     */
    public function exists($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    /**
     * Create session variable
     * @param  name $name    session name
     * @param  value $string session value
     * @return string        session value
     */
    public function put($name, $string)
    {
        if (isset($_SESSION)) {
            return $_SESSION[$name] = $string;
        }
    }

    /**
     * Get session value
     * @param  string $name session name
     * @return string       value
     */
    public function get($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    /**
     * Get all session values
     * @return array session values
     */
    public function getAll()
    {
        return $_SESSION;
    }

    /**
     * Add values to session element
     * @param  string $name session name
     * @return string       value
     */
    public function add($name, $value)
    {
        $keys = explode('/', $name);
        return $_SESSION[$keys[0]][$keys[1]][] = $value;
    }

    /**
     * Delete a session variable
     * @param  string $name variable name
     * @return void
     */
    public function delete($name)
    {
        if (isset($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Destroy all session data
     * @return void
     */
    public function destroy()
    {
        session_destroy();
    }
}
