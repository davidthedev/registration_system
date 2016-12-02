<?php

namespace App\Database;

interface DatabaseAdapterInterface {
    public function prepare($sql);
    public function execute(array $bind);
    public function getStatement();
    public function insert($table, array $bind);
    public function select($table, array $bind);
    public function update($table, array $bind);
    public function getLastInsertId();
    public function fetch();
    public function fetchAll();
}
