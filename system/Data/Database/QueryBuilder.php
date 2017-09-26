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

    public function raw($sql, $data = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->bind($stmt, $data);
        $stmt->execute();

        if (preg_match('/insert/i', $sql)) {
            return $this->pdo->lastInsertId();
        } elseif (preg_match('/select/i', $sql)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $stmt->rowCount();
    }

    public function select($table, $fields, $conditions = [])
    {
        $sql = sprintf('SELECT %s FROM %s',
            implode(', ', $fields), $table
        );

        if (!empty($conditions)) {
            $sql .= sprintf(' WHERE %s',
                $this->where($conditions)
            );
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->bind($stmt, $conditions);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $table, implode(', ', array_keys($data)),
            ':' . implode(', :', array_keys($data))
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->bind($stmt, $data);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $conditions)
    {
        $sql = sprintf('UPDATE %s SET %s WHERE %s', $table,
            $this->where($data, ', '),
            $this->where($conditions)
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->bind($stmt, $data);
        $stmt = $this->bind($stmt, $conditions);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete($table, $conditions)
    {
        $sql = sprintf('DELETE FROM %s WHERE %s',
            $table, $this->where($conditions)
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt = $this->bind($stmt, $conditions);
        $stmt->execute();

        return $stmt->rowCount();
    }

    private function bind($stmt, $params)
    {
        foreach ($params as $key => $value) {
            $type = false;

            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_string($value)) {
                $type = PDO::PARAM_STR;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL;
            }

            if ($type) {
                $stmt->bindValue(":{$key}", $value, $type);
            }
        }

        return $stmt;
    }

    private function where($conditions, $logic = 'AND')
    {
        $sql = '';
        foreach (array_keys($conditions) as $key) {
            $sql .= " {$logic} {$key} = :{$key}";
        }

        return ltrim($sql, " {$logic} ");
    }
}
