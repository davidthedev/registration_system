<?php

namespace App\Database;

/**
 *  Base data mapper includes common methods that can be used by
 *  other mappers such as looking up in the database up by id,
 *  updating by id and fetching results. This class contains an abstract
 *  method create entity which creates object from fetched result.
 *  Methods are self-explanatory
 */
abstract class AbstractDataMapper {

    /**
     * Database adapter
     * @var object
     */
    protected $adapter;

    /**
     * Inject database adapter instance defined using an interface
     * @param DatabaseAdapterInterface $adapter database adapter instance
     */
    public function __construct(DatabaseAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
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

    public function findById($id)
    {
        $row = $this->adapter->select($this->entityTable,
            ['id' => $id])->fetch();
        if (!$row) {
            return null;
        }
        return $this->createEntity($row);
    }

    public function fetchAll(array $conditions = [], array $sort = [])
    {
        $rows = $this->adapter->select($this->entityTable, $conditions, $sort)
                              ->fetchAll();

        if (!$rows) {
            return false;
        }

        $rowsCollection = [];
        foreach ($rows as $row) {
            $rowsCollection[] =  $this->createEntity($row);
        }
        return $rowsCollection;
    }

    abstract protected function createEntity($row);
}
