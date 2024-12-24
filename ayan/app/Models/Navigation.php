<?php

namespace App\Models;

use App\Core\Database;

class Navigation {
    private $db;
    private $table = 'Navigation';

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllNavigations() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
