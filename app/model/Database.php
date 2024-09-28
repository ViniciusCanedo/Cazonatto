<?php
namespace App\Model;
use PDO;

class Database{
    private string $table;
    private PDO $conn;

    public function __construct(string $table){
        $this->table = $table;

        try {
            $this->conn = new PDO('sqlite:/var/www/html/app/database/cazonatto.db');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo $e->getMessage();
        }
    }

    private function execute($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return $stmt;
        } catch (\PDOException $e) {
            exit('ERROR:'.$e->getMessage());
        }
    }

    public function insert($values)
    {
        $columns = array_keys($values);
        $binds = array_pad([], count($columns), '?');

        $query = 'INSERT INTO '.$this->table.'('.implode(',', $columns).') VALUES('.implode(',', $binds).')';

        $this->execute($query, array_values($values));

        return $this->conn->lastInsertId();
    }

    public function select($where = null, $columns = [], $join = null, $groupOrder = null, $limit = null)
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $columns = empty($columns) ? '*' : implode(", ", $columns); 
        $join = strlen($join) ? $join : '';
        $groupOrder = strlen($groupOrder) ? $groupOrder : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' .$columns. ' FROM ' . $this->table . ' ' .$join. ' ' .$where. ' ' .$groupOrder. ' ' .$limit;

        return $this->execute($query);
    }

    public function update($where, $set) 
    {
        $where = strlen($where) ? 'WHERE ' .$where : '';
        $columns = array_keys($set);
        $values  = array_values($set);
        $set = array_map(function($column, $value){
            return $column . ' = ' . $value;
        }, $columns, $values);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode(',', $set) . ' ' . $where;
        
        $this->execute($query);

        return true;
    }

    public function delete($where)
    {
        $where = strlen($where) ? 'WHERE ' .$where : '';

        $query = 'DELETE FROM ' .$this->table. ' ' .$where;

        $this->execute($query);

        return true;
    }
}