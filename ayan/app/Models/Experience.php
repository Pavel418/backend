<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Experience {
    private $db;
    private $table = 'Experience';

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function create($date, $depart_time, $arrival_time, $distance, $navigation_id, $road_id, $traffic_id, $weather_id) {
        $query = "INSERT INTO {$this->table} (date, depart_time, arrival_time, distance, navigation_id, road_id, traffic_id, weather_id) 
                  VALUES (:date, :depart_time, :arrival_time, :distance, :navigation_id, :road_id, :traffic_id, :weather_id)";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':depart_time', $depart_time);
        $stmt->bindParam(':arrival_time', $arrival_time);
        $stmt->bindParam(':distance', $distance);
        $stmt->bindParam(':navigation_id', $navigation_id);
        $stmt->bindParam(':road_id', $road_id);
        $stmt->bindParam(':traffic_id', $traffic_id);
        $stmt->bindParam(':weather_id', $weather_id);

        return $stmt->execute();
    }

    public function getTotalKms() {
        $query = "SELECT SUM(distance) as total_kms FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['total_kms'] : 0;
    }
    
    public function getAllExperiences() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
    
    public function resetExperiences() {
        try {
            $this->db->beginTransaction();
    
            $query = "DELETE FROM Experience_Maneuver WHERE experience_id IN (SELECT experience_id FROM {$this->table})";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
    
            $query = "DELETE FROM {$this->table}";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
    
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function getNavigationData() {
        $query = "
            SELECT 
                n.navigation_id,
                n.navigation AS navigation_name,
                COUNT(e.navigation_id) AS count
            FROM {$this->table} e
            JOIN Navigation n ON e.navigation_id = n.navigation_id
            GROUP BY n.navigation_id, n.navigation
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTrafficData() {
        $query = "
            SELECT 
                t.traffic_id,
                t.traffic AS traffic_type,
                COUNT(e.traffic_id) AS count
            FROM {$this->table} e
            JOIN Traffic t ON e.traffic_id = t.traffic_id
            GROUP BY t.traffic_id, t.traffic
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getWeatherData() {
        $query = "
            SELECT 
                w.weather_id,
                w.weather AS weather_condition,
                COUNT(e.weather_id) AS count
            FROM {$this->table} e
            JOIN Weather w ON e.weather_id = w.weather_id
            GROUP BY w.weather_id, w.weather
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRoadData() {
        $query = "
            SELECT 
                r.road_id,
                r.road AS road_name,
                COUNT(e.road_id) AS count
            FROM {$this->table} e
            JOIN Road r ON e.road_id = r.road_id
            GROUP BY r.road_id, r.road
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function cumulativeMonthlyDistance()
    {
        $query = "
            SELECT 
                year,
                month,
                SUM(total_distance) OVER (ORDER BY year, month) AS total_distance
            FROM (
                SELECT 
                    YEAR(date) AS year,
                    MONTH(date) AS month,
                    SUM(distance) AS total_distance
                FROM Experience
                GROUP BY YEAR(date), MONTH(date)
                ORDER BY year, month
            ) AS monthly_distance;
        ";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteExperience($experience_id) {
        try {
            $this->db->beginTransaction();
    
            $query = "DELETE FROM Experience_Maneuver WHERE experience_id = :experience_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':experience_id', $experience_id);
            $stmt->execute();
    
            $query = "DELETE FROM {$this->table} WHERE experience_id = :experience_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':experience_id', $experience_id);
            $stmt->execute();
    
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getExperience($experience_id) {
        $query = "SELECT * FROM {$this->table} WHERE experience_id = :experience_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':experience_id', $experience_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($experience_id, $date, $depart_time, $arrival_time, $distance, $navigation_id, $road_id, $traffic_id, $weather_id) {
        $query = "UPDATE {$this->table} SET date = :date, depart_time = :depart_time, arrival_time = :arrival_time, distance = :distance, navigation_id = :navigation_id, road_id = :road_id, traffic_id = :traffic_id, weather_id = :weather_id WHERE experience_id = :experience_id";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':experience_id', $experience_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':depart_time', $depart_time);
        $stmt->bindParam(':arrival_time', $arrival_time);
        $stmt->bindParam(':distance', $distance);
        $stmt->bindParam(':navigation_id', $navigation_id);
        $stmt->bindParam(':road_id', $road_id);
        $stmt->bindParam(':traffic_id', $traffic_id);
        $stmt->bindParam(':weather_id', $weather_id);

        return $stmt->execute();
    }

    public function addRandomData() {
        $query = "
        INSERT INTO Experience (depart_time, arrival_time, date, distance, navigation_id, road_id, traffic_id, weather_id)
        SELECT 
            SEC_TO_TIME(FLOOR(RAND() * 86400)),  -- Random depart_time (seconds since midnight, within 24 hours)
            SEC_TO_TIME(FLOOR(RAND() * 86400)),  -- Random arrival_time (seconds since midnight, within 24 hours)
            DATE_ADD(CURRENT_DATE, INTERVAL FLOOR(RAND() * 365) DAY), -- Random date (within the past 365 days)
            FLOOR(RAND() * 1000) + 1,  -- Random distance (between 1 and 1000)
            FLOOR(RAND() * 3) + 1,     -- Random navigation_id (between 1 and 3)
            FLOOR(RAND() * 5) + 1,     -- Random road_id (between 1 and 5)
            FLOOR(RAND() * 5) + 1,     -- Random traffic_id (between 1 and 5)
            FLOOR(RAND() * 5) + 1      -- Random weather_id (between 1 and 5)
        FROM 
            (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION 
            SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) AS temp;

        INSERT INTO Experience_Maneuver (experience_id, maneuver_id)
        SELECT 
            exp.experience_id,
            maneuver_id.maneuver_id
        FROM 
            Experience AS exp
        JOIN 
            (SELECT 1 AS maneuver_id UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) AS maneuver_id
        LEFT JOIN 
            Experience_Maneuver AS em
            ON exp.experience_id = em.experience_id AND maneuver_id.maneuver_id = em.maneuver_id
        WHERE 
            RAND() < 0.5 AND em.experience_id IS NULL;  -- Insert only if the combination doesn't already exist
        ";
        return $this->db->exec($query);
    }
}
