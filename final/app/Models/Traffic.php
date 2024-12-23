<?php

namespace App\Models;

use App\Core\Database;

class Traffic {
    private $db;
    private $table = 'Traffic';

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllTraffic() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
