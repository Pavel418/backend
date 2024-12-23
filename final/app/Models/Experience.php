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
        $stmt = $this->db->query($query);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['total_kms'] : 0;
    }

    public function getAllExperiences() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($query);
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

     public function getMonthlyNavigationData()
     {
         $query = "
             SELECT 
                 MONTH(FROM_UNIXTIME(date)) AS month,
                 COUNT(DISTINCT navigation_id) AS count
             FROM {$this->table}
             GROUP BY month
         ";
         return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
     }
 
     public function getMonthlyRoadData()
     {
         $query = "
             SELECT 
                 MONTH(FROM_UNIXTIME(date)) AS month,
                 COUNT(DISTINCT road_id) AS count
             FROM {$this->table}
             GROUP BY month
         ";
         return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
     }
 
     public function getMonthlyTrafficData()
     {
         $query = "
             SELECT 
                 MONTH(FROM_UNIXTIME(date)) AS month,
                 COUNT(DISTINCT traffic_id) AS count
             FROM {$this->table}
             GROUP BY month
         ";
         return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
     }
 
     public function getMonthlyWeatherData()
     {
         $query = "
             SELECT 
                 MONTH(FROM_UNIXTIME(date)) AS month,
                 COUNT(DISTINCT weather_id) AS count
             FROM {$this->table}
             GROUP BY month
         ";
         return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
     }
 
     public function getTripDistances()
     {
         $query = "
             SELECT 
                 FROM_UNIXTIME(date) AS date,
                 distance
             FROM {$this->table}
         ";
         return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getHeatmapData()
    {
        $trafficQuery = "SELECT traffic_id, traffic FROM Traffic";
        $weatherQuery = "SELECT weather_id, weather FROM Weather";

        $trafficConditions = $this->db->query($trafficQuery)->fetchAll(PDO::FETCH_ASSOC);
        $weatherConditions = $this->db->query($weatherQuery)->fetchAll(PDO::FETCH_ASSOC);

        $heatmapMatrix = [];
        foreach ($trafficConditions as $traffic) {
            foreach ($weatherConditions as $weather) {
                $heatmapMatrix[$traffic['traffic_id']][$weather['weather_id']] = 0;
            }
        }

        $query = "
            SELECT 
                e.traffic_id,
                e.weather_id,
                COUNT(*) AS count
            FROM {$this->table} e
            GROUP BY e.traffic_id, e.weather_id
        ";

        $results = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            $heatmapMatrix[$result['traffic_id']][$result['weather_id']] = $result['count'];
        }

        return [
            'matrix' => $heatmapMatrix,
            'trafficConditions' => $trafficConditions,
            'weatherConditions' => $weatherConditions
        ];
    }
}
