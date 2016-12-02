<?php

namespace App\Domain\User;

/**
 * Password class creates and verifies password
 */
class Password {

    private $value;

    /**
     * Hash a password
     * @param  password  $value  password entered by the user
     * @return mixed             return either hashed password or
     *                                  false on failure
     */
    public function hash($value)
    {
        return password_hash($value, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    /**
     * Compare hashed and use entered passwords
     * @param  string $enteredPass   unhashed password
     * @param  string $savedPassword saved hashed password
     * @return boolean               true if match
     */
    public function compare($enteredPass, $savedPassword)
    {
        return password_verify($enteredPass, $savedPassword);
    }

    /**
     * Password getter
     * @return string password value
     */
    public function getValue()
    {
        return $this->value;
    }
}
