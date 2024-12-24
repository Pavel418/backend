<?php

namespace App\Models;

use App\Core\Database;

class ExperienceManeuver {
    private $db;
    private $table = 'Experience_Maneuver';

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function associateExperienceWithManeuver($experience_id, $maneuver_id) {
        $query = "INSERT INTO {$this->table} (experience_id, maneuver_id) 
                  VALUES (:experience_id, :maneuver_id)";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':experience_id', $experience_id);
        $stmt->bindParam(':maneuver_id', $maneuver_id);

        return $stmt->execute();
    }

    public function dissociateExperienceWithAllManeuvers($experience_id) {
        $query = "DELETE FROM {$this->table} WHERE experience_id = :experience_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':experience_id', $experience_id);
        return $stmt->execute();
    }

    public function getAssociatedManeuvers($experience_id) {
        $query = "SELECT * FROM {$this->table} WHERE experience_id = :experience_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':experience_id', $experience_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
