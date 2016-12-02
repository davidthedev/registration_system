<?php

namespace App\Domain\User;

use Ramsey\Uuid\Uuid;
/**
 * UserId class uses Ramsey/UUID php libray by Ben Ramsey
 * to generate universally unique identifier to be used a user id
 * This allows us to not rely on database to generate ids
 */
class UserId {

    private $value;

    public function __construct()
    {
        $this->value = Uuid::uuid4();
    }

    public function __toString()
    {
        return $this->value->toString();
    }

    public function getValue()
    {
        return $this->value->toString();
    }
}
