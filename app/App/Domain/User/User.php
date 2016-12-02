<?php

namespace App\Domain\User;

/**
 * User class creates a user object. Two static 'factory' methods
 * allow to create user object from different states, upon registration and
 * upon fetching user details from the database
 */
class User
{

    private $id, $firstname, $username, $email, $password, $group;

    private function __construct($id, $firstname, $username, $email, $password, $group)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->group = $group;
    }

    /**
     * Create User object from UserService class after registration
     * @param  UserId  $id        user id object used to create UUID id
     * @param  string  $firstname user firstname
     * @param  string  $username  user username
     * @param  string  $email     user email
     * @param  string  $password  user password
     * @param  integer $group     user group
     * @return object             user object
     */
    public static function fromState(UserId $id, $firstname, $username, $email,
        $password, $group)
    {
        return new self($id->getValue(), $firstname, $username, $email,
            $password, $group);
    }

    /**
     * Create User object from fetched database result
     * @param  string $id        fetched user id
     * @param  string $firstname fetched user firstname
     * @param  string $username  fetched user username
     * @param  string $email     fetched user email
     * @param  string $password  fetched user email
     * @param  string $group     fetched group number
     * @return object            new user object
     */
    public static function fromDb($id, $firstname, $username, $email,
        $password, $group)
    {
        return new self($id, $firstname, $username, $email,
            $password, $group);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getGroup()
    {
        return $this->group;
    }
}
