<?php

namespace App\Models;

use App\Core\Database;

class Road {
    private $db;
    private $table = 'Road';

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllRoads() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
