<?php

namespace App\Domain\User;

use App\Database\AbstractDataMapper as AbstractDataMapper;
use App\Domain\User\UserMapperInterface as UserMapperInterface;

/**
 *  UserMapper adds, finds user. Performs data transfer between database and
 *  in memory user representation.
 */
class UserMapper extends AbstractDataMapper implements UserMapperInterface {

    protected $entityTable = 'users';

    public function add(User $user)
    {
        $userId = $this->adapter->insert($this->entityTable,
            [   'id' => $user->getId(),
                'firstname' => $user->getFirstname(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'group' => $user->getGroup()]);
        return $userId;
    }

    public function updateById($id, array $params)
    {

        $userParams = ['id' => $id];

        foreach ($params as $column => $value) {
            $userParams[$column] = $value;
        }

        $this->adapter->update($this->entityTable, $userParams);
        return true;
    }

    public function findByUsername($username)
    {
        $row = $this->adapter->select($this->entityTable,
            ['username' => $username])->fetch();
        if (!$row) {
            return false;
        } else {
            $user = $this->createEntity($row);
            return $user;
        }
    }

    public function findByEmail($email)
    {
        $row = $this->adapter->select($this->entityTable,
            ['email' => $email])->fetch();
        if (!$row) {
            return false;
        } else {
            $user = $this->createEntity($row);
            return $user;
        }
    }

    public function delete($id)
    {

    }

    protected function createEntity($row)
    {
        $user = User::fromDb($row->id, $row->firstname,
            $row->username, $row->email, $row->password, $row->group);
        return $user;
    }
}
