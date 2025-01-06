<?php

namespace Framework\Helpers;

class PdoQuery {
    public static function insertFieldsSet(array $fields): string {
        /*
        query = "INSERT INTO Table
        ('field1', 'field2', 'field3', 'field4' ...)
        VALUES
        (:field1, :field2, :field3, :field4, ...)"

        after help:

        query = "INSERT INTO Table
        $fieldsSet
        VALUES
        (:field1, :field2, :field3, :field4, ...)"
        */

        $fieldsSet = '(';
        for ($i = 0; $i < count($fields); $i++) {
            if ($i === 0) $fieldsSet .= "'{$fields[$i]}'";
            else $fieldsSet .= ", '{$fields[$i]}'";
        }
        $fieldsSet .= ')';
        return $fieldsSet;
        
        // $fieldsSet = " ('field1', 'field2', ...) "
    }
    public static function insertValuesSet(array $fields): string {
        /*
        query = "INSERT INTO Table 
        ('field1', 'field2', 'field3', 'field4', ...)
        VALUES
        (:field1, :field2, :field3, :field4, ...)"

        after help:

        query = "INSERT INTO Table
        ('field1', 'field2', 'field3', 'field4', ...)
        VALUES
        $valuesSet"
        */
        
        $valuesSet = '(';
        for ($i = 0; $i < count($fields); $i++) {
            if ($i === 0) $valuesSet .= ":{$fields[$i]}";
            else $valuesSet .= ", :{$fields[$i]}";
        }
        $valuesSet .= ')';
        return $valuesSet;

        // $valuesSet = " (:field1, :field2, ...) "
    }
    public static function updateSet(array $fields): string {
        /*
        query = "UPDATE Table SET
        field1 = :field1,
        field2 = :field2,
        field3 = :field3
        ...
        WHERE ..."
        
        after code:
        
        query = "UPDATE Table SET
        $fieldsSet
        WHERE ..."
        */

        $updateSet = '';
        for ($i = 0; $i < count($fields); $i++) {
            if ($i === 0) $updateSet .= "{$fields[$i]} = :{$fields[$i]}";
            else $updateSet .= ", {$fields[$i]} = :{$fields[$i]}";
        }
        return $updateSet;

        // $updateSet = " field1 = :field1, field2 = :field2, ... "
    }
    public static function execArray(array $fields, array $values): array {
        /*
        $query->execute([
            ':field1' => $value1,
            ':field2' => $value2,
            ':field3' => $value3,
            ':field4' => $value4,
            ...
        ])

        after help:

        $query->execute($execArray)
        */

        $execArray = [];
        for ($i = 0; $i < count($fields); $i++) {
            $execArray[":{$fields[$i]}"] = $values[$i];
        }
        return $execArray;

        /*
        $execArray = [
            ':field1' => $value1,
            ':field2' => $value2,
            ':field3' => $value3,
            ':field4' => $value4,
            ...
        ]
        */
    }

    public static function validationsSet(array $fields): string {
        $validationsSet = '';

        for ($i = 0; $i < count($fields); $i++) {
            if ($i === 0) $validationsSet .= "{$fields[$i]} = :{$fields[$i]}";
            else $validationsSet .= " AND {$fields[$i]} = :{$fields[$i]}";
        }

        return $validationsSet;
    }
}