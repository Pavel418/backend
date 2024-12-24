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
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
