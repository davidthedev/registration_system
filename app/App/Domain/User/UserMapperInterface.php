<?php

namespace App\Domain\User;

interface UserMapperInterface {
    public function add(User $user);
    public function findByUsername($username);
    public function findByEmail($email);
}
