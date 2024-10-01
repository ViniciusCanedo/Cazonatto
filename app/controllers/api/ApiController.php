<?php
namespace App\Controllers\Api;

use App\Model\Database;

class ApiController{
    public function add(string $table): void{
        $db = new Database($table);
        $id = $db->insert($_POST);

        $this->getOne($table, $id);
    }

    public function getOne(string $table, int $id): void{
        $db = new Database($table);

        header('Content-Type: application/json');
        echo json_encode($db->select("id = $id")->fetch(\PDO::FETCH_ASSOC));
    }

    public function listAll(string $table): void{
        $db = new Database($table);

        header('Content-Type: application/json');
        echo json_encode($db->select()->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function modify($table, $id): void{
        $data = json_decode(file_get_contents('php://input'), true);
        $db = new Database($table);
        $db->update("id = $id", $data);

        $this->getOne($table, $id);
    }

    public function remove($table, $id): void{
        $db = new Database($table);
        $db->delete("id = $id");
    }
}