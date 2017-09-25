<?php

namespace System\Data\Database;

use PDO;

class QueryBuilder
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function select($table, $fields, $conditions = [])
    {
        $sql = sprintf('SELECT %s FROM %s', implode(', ', $fields), $table);
        if (!empty($conditions)) {
            $sql .= sprintf(' WHERE %s', $this->where($conditions));
        }

        $stmt = $this->pdo->prepare($sql);
        $this->bind($stmt, $conditions)->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        ksort($data);
        $names = implode(', ', array_keys($data));
        $values = ':data_' . implode(', :data_', array_keys($data));
        $statement = $this->pdo->prepare("INSERT INTO {$table} ({$names}) VALUES ({$values})");
        $statement = $this->binds($statement, $data);
        $statement->execute();
        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $where)
    {
        ksort($data);
        ksort($where);
        $dataDetails = $this->details($data, ',');
        $whereDetails = $this->details($where, 'AND', 'where');
        $statement = $this->pdo->prepare("UPDATE {$table} SET {$dataDetails} WHERE {$whereDetails}");
        $statement = $this->binds($statement, $data);
        $statement = $this->binds($statement, $where, 'where');
        $statement->execute();
        return $statement->rowCount();
    }

    public function delete($table, $where)
    {
        ksort($where);
        $whereDetails = $this->details($where);
        $statement = $this->pdo->prepare("DELETE FROM {$table} WHERE {$whereDetails}");
        $statement = $this->binds($statement, $where);
        $statement->execute();
        return $statement->rowCount();
    }

    public function raw($sql, $params = array())
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        if (preg_match('/insert/i', $sql)) {
            return $this->pdo->lastInsertId();
        } elseif (preg_match('/update/i', $sql)) {
            return $statement->rowCount();
        } elseif (preg_match('/delete/i', $sql)) {
            return $statement->rowCount();
        } elseif (preg_match('/select/i', $sql)) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $statement->rowCount();
        }
    }

    private function where($conditions)
    {
        $sql = '';
        foreach (array_values($conditions) as $value) {
            $sql .= " AND {$value[0]} {$value[1]} :{$value[0]}";
        }

        return ltrim($sql, " AND ");
    }

    private function bind($stmt, $conditions)
    {
        foreach (array_values($conditions) as $value) {
            $param = false;

            if (is_int($value[2])) {
                $param = PDO::PARAM_INT;
            } elseif (is_string($value[2])) {
                $param = PDO::PARAM_STR;
            } elseif (is_bool($value[2])) {
                $param = PDO::PARAM_BOOL;
            } elseif (is_null($value[2])) {
                $param = PDO::PARAM_NULL;
            }

            if ($param) {
                $stmt->bindValue(":{$value[0]}", $value[2], $param);
            }
        }

        return $stmt;
    }
}
