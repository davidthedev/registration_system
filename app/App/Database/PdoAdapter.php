<?php

namespace App\Database;

use PDO;
use App\Core\Config;
use App\Database\DatabaseAdapterInterface as DatabaseAdapterInterface;

/**
 * PdoAdapter class provides access to SQL database using PDO extension
 */
class PdoAdapter implements DatabaseAdapterInterface {

    protected $connection;
    protected $statement;

    public function __construct()
    {
        try {
            $driver = Config::get('DB_DRIVER');
            $dbName = 'dbname=' . Config::get('DB_NAME');
            $dbHost = 'host=' . Config::get('DB_HOST');
            $username = Config::get('DB_USERNAME');
            $password = Config::get('DB_PASSWORD');
            $dns = $driver . ':' . $dbHost . ';' . $dbName;
            $this->connection = new PDO($dns, $username, $password);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function prepare($sql)
    {
        try {
            $this->statement = $this->connection->prepare($sql);
            return $this;
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }

    public function execute(array $bind)
    {
        foreach ($bind as $column => $value) {
            $this->getStatement()->bindValue($column, $value);
        }
        try {
            $this->getStatement()->execute();
            return $this;
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }

    public function getStatement()
    {
        return $this->statement;
    }

    public function insert($table, array $bind)
    {
        $columns = implode('`, `', array_keys($bind));
        $values = implode(', :', array_keys($bind));
        foreach ($bind as $column => $value) {
            unset($bind[$column]);
            $bind[':' . $column] = $value;
        }
        $sql = 'INSERT INTO ' . $table . ' (`' . $columns . '`) ';
        $sql .= 'VALUES (:' . $values . ')';
        return (int) $this->prepare($sql)->execute($bind)->getLastInsertId();
    }

    public function select($table, array $bind = [], array $sort = [])
    {
        if (!empty($bind)) {
            foreach ($bind as $column => $value) {
                $where[] = $column . ' = ' . ':' . $column;
                unset($bind[$column]);
                $bind[':' . $column] = $value;
            }
            $values = implode(' AND ', $where);
        }

        // e.g. 'date' => 'ASC', 'title' => 'DESC'
        if (!empty($sort)) {
            foreach ($sort as $column => $order) {
                unset($sort[$column]);
                $sort[] = $column . ' ' . $order;
            }
            $sort = implode(', ', $sort);
        }

        $sql = 'SELECT * FROM `' . $table . '` ';
        ($bind) ? $sql .= 'WHERE ' . $values : '';
        ($sort) ? $sql .= ' ORDER BY ' . $sort : '';

        $this->prepare($sql)->execute($bind);
        return $this;
    }

    public function selectJoin()
    {
        $sql = 'SELECT posts.id, posts.title, posts.body, posts.image_link, posts.date, users.firstname
            FROM posts RIGHT JOIN users ON posts.user_id = users.id ORDER BY date DESC';
        $sql = $this->prepare($sql)->execute([]);
        return $sql->fetchAll();
    }

    public function update($table, array $bind)
    {
        foreach ($bind as $column => $value) {
            unset($bind[$column]);
            $bind[':' . $column] = $value;
            if ($column !== 'id' && $column) {
                $set[] = ' `' . $column . '` = :' . $column;
            }
        }

        $sql  = 'UPDATE `' . $table . '` ';
        $sql .= 'SET ' . implode(', ', $set) . ' ';
        $sql .= 'WHERE `id` = :id';

        $this->prepare($sql)->execute($bind);
    }

    public function delete($table, array $bind)
    {
        foreach ($bind as $column => $value) {
            unset($bind[$column]);
            $bind[':' . $column] = $value;
            $set[] = ' `' . $column . '` = :' . $column;
        }

        $sql = 'DELETE FROM `' . $table . '` ';
        $sql .= 'WHERE ' . implode(', ', $set);
        $this->prepare($sql)->execute($bind);
    }

    public function getLastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    public function fetch()
    {
        return $this->getStatement()->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll()
    {
        return $this->getStatement()->fetchAll(PDO::FETCH_OBJ);
    }
}
