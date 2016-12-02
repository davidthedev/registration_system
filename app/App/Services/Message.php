<?php

namespace App\Services;

/**
 * Message class is basicaly a storage of messages for various situations
 */
class Message
{

    protected $message = [
        // user messages
        'MESSAGE_WELCOME' => 'Welcome, ',
        'MESSAGE_USERNAME_OR_PASSWORD_INCORRECT' => 'A combination of username / password is incorrect.',
        'MESSAGE_USER_NOT_FOUND' => 'There is no account associated with this username.',
        'MESSAGE_EMAIL_OR_USERNAME_EXISTS' => 'Email / username already exists.',
        'MESSAGE_REGISTRATION_SUCCESSFUL' => 'You have successfully registered.',
        'MESSAGE_LOGIN_SUCCESSFUL' => 'You have successfully logged in.',
        // form messages
        'MESSAGE_CSRF_ERROR' => 'Form protection token mismatch. Try again.',
        'MESSAGE_PASSWORD_UPDATED' => 'Password has been successfully updated.',
        'MESSAGE_DETAILS_UPDATED' => 'Your details have been successfully updated.',
        'MESSAGE_DETAILS_ERROR' => 'There has been an error while updating your details'
    ];

    public function get($key)
    {
        if (isset($this->message[$key])) {
            return $this->message[$key];
        }
        return 'Message key not recognised.';
    }
}
