<?php

namespace Framework\Mvc;

use Framework\Helpers\PdoQuery;
use Framework\Helpers\ArrayTrat;

use App\Database\Connection;

abstract class Model {
    protected static \PDO $connection;

    protected string $table;
    protected array $fields;

    protected function init(string $db, string $table, array $fields): void {
        self::$connection = Connection::getInstance($db);

        $this->table = $table;
        $this->fields = $fields;
    }

    /* ------------ SELECT ------------ */

    public function selectAll(): array|false {
        $query = self::$connection->query("SELECT rowid, * FROM {$this->table}");

        return $query->fetchAll();
    }

    public function selectById(int $id): \stdClass|false {
        $query = self::$connection->prepare("SELECT rowid, * FROM {$this->table} WHERE rowid=:id");
        $query->execute([':id' => $id]);
        
        return $query->fetchObject();
    }

    public function selectByField(string $field, string $value): \PDOStatement {
        $query = self::$connection->prepare("SELECT rowid, * FROM {$this->table} WHERE $field=:value");
        $query->execute([":value" => $value]);

        return $query;
    }

    public function selectByFields(array $fields_values): \PDOStatement {
        $arrays = ArrayTrat::turnOneArrayToArrays($fields_values);
        $fields = $arrays['keys'];
        $values = $arrays['values'];
    
        $validationsSet = PdoQuery::validationsSet($fields);
        $execArray = PdoQuery::execArray($fields, $values);

        $query = self::$connection->prepare("SELECT rowid, * FROM {$this->table} WHERE $validationsSet");
        $query->execute($execArray);

        return $query;
    }

    public function selectColumn(string $field): array|false {
        $query = self::$connection->query("SELECT DISTINCT $field FROM {$this->table}");
        $column = $query->fetchAll();

        if (!$column) return false;

        $newColumn = [];
        foreach ($column as $value) $newColumn[] = $value->$field;

        return $newColumn;
    }

    /* ------------ INSERT ------------ */

    public function insert(array $values): bool {
        $fieldsSet = PdoQuery::insertFieldsSet($this->fields);
        $valuesSet = PdoQuery::insertValuesSet($this->fields);
        $execArray = PdoQuery::execArray($this->fields, $values);

        $query = self::$connection->prepare("INSERT INTO {$this->table} $fieldsSet VALUES $valuesSet");
        $exec = $query->execute($execArray);

        return $exec;
    }

    /* ------------ UPDATE ------------ */

    public function updateById(int $id, array $fields_values): bool {
        $arrays = ArrayTrat::turnOneArrayToArrays($fields_values);
        $fields = $arrays['keys'];
        $values = $arrays['values'];
    
        $updateSet = PdoQuery::updateSet($fields);
        $execArray = PdoQuery::execArray($fields, $values);
        $execArray[':id'] = $id;

        $query = self::$connection->prepare("UPDATE {$this->table} SET $updateSet WHERE rowid = :id");
        $exec = $query->execute($execArray);

        return $exec;
    }

    public function updateByFields(array $searchFields_searchValues, array $fields_values): bool {
        $searchArrays = ArrayTrat::turnOneArrayToArrays($searchFields_searchValues);
        $searchFields = $searchArrays['keys'];
        $searchValues = $searchArrays['values'];
    
        $arrays = ArrayTrat::turnOneArrayToArrays($fields_values);
        $fields = $arrays['keys'];
        $values = $arrays['values'];
    
        $updateSet = PdoQuery::updateSet($fields);
        $execArray = PdoQuery::execArray(array_merge($fields, $searchFields), array_merge($values, $searchValues));

        $condition = PdoQuery::validationsSet($searchFields);
        
        $query = self::$connection->prepare("UPDATE {$this->table} SET $updateSet WHERE $condition");
        $exec = $query->execute($execArray);

        return $exec;
    }

    public function updateAllById(int $id, array $values): bool {
        $updateSet = PdoQuery::updateSet($this->fields);
        $execArray = PdoQuery::execArray($this->fields, $values);
        $execArray[':id'] = $id;
        
        $query = self::$connection->prepare("UPDATE {$this->table} SET $updateSet WHERE rowid = :id");
        $exec = $query->execute($execArray);

        return $exec;
    }

    public function updateAllByField(string $searchField, string $searchValue, array $values): bool {
        $updateSet = PdoQuery::updateSet($this->fields);
        $execArray = PdoQuery::execArray($this->fields, $values);
        $execArray[':searchValue'] = $searchValue;
        
        $query = self::$connection->prepare("UPDATE {$this->table} SET $updateSet WHERE $searchField = :searchValue");
        $exec = $query->execute($execArray);

        return $exec;
    }

    /* ------------ DELETE ------------ */

    public function deleteById(int $id): void {
        $query = self::$connection->prepare("DELETE FROM {$this->table} WHERE rowid = :id");
        $query->execute([':id' => $id]);
    }

    public function deleteByField(string $field, $value): void {
        $query = self::$connection->prepare("DELETE FROM {$this->table} WHERE $field = :value");
        $query->execute([':value' => $value]);
    }

    public function deleteByFields(array $fields_values): void {
        $arrays = ArrayTrat::turnOneArrayToArrays($fields_values);
        $fields = $arrays['keys'];
        $values = $arrays['values'];
    
        $validationsSet = PdoQuery::validationsSet($fields);
        $execArray = PdoQuery::execArray($fields, $values);

        $query = self::$connection->prepare("DELETE FROM {$this->table} WHERE $validationsSet");
        $query->execute($execArray);
    }
}
