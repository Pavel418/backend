<?php

namespace App\Models;

use App\Core\Database;

class Maneuver {
    private $db;
    private $table = 'Maneuver';

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllManeuvers() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
