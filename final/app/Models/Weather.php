<?php

namespace App\Models;

use App\Core\Database;

class Weather {
    private $db;
    private $table = 'Weather';

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllWeather() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
