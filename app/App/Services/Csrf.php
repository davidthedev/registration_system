<?php

namespace App\Services;

use App\Core\Config;
use App\Services\Session;

/**
 * CSRF trait deals with generating and verifying tokens for forms
 */
trait Csrf {

    /**
     * Generate Cross Site Request Forgery token
     * and put into session variable
     * @param  string $token csrf token name from config file
     * @return string        generated csrf token value
     */
    public function generateCsrfToken($token)
    {
        $tokenValue = md5(rand());
        return $this->session->put($token, $tokenValue);
    }

    /**
     * Verify csrf token value
     * @param  string $original config csrf value
     * @param  string $token    token to verify
     * @return boolean       token verified or not?
     */
    public function verifyCsrfToken($original, $token)
    {
        if ($token == $this->session->get($original)) {
            $this->session->delete($original);
            return true;
        }
        return false;
    }
}
