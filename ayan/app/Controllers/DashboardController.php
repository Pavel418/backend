<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Experience;
use App\Models\Weather;
use App\Models\Road;
use App\Models\Navigation;
use App\Models\Traffic;
use App\Models\Maneuver;
use App\Models\ExperienceManeuver;

class DashboardController {
    private function generateCode() {
        return bin2hex(random_bytes(8));
    }

    public function index() {
        session_start();
        session_destroy();
        session_start();

        $experienceModel = new Experience();
        $weatherModel = new Weather();
        $roadModel = new Road();
        $trafficModel = new Traffic();
        $navigationModel = new Navigation();
        $maneuverModel = new Maneuver();

        $experiences = $experienceModel->getAllExperiences();
        $totalDistance = $experienceModel->getTotalKms();

        $weatherOptions = $weatherModel->getAllWeather();
        $roadTypeOptions = $roadModel->getAllRoads();
        $trafficOptions = $trafficModel->getAllTraffic();
        $navigationTypeOptions = $navigationModel->getAllNavigations();
        $maneuvers = $maneuverModel->getAllManeuvers();

        $experienceManeuverModel = new ExperienceManeuver();
        foreach ($experiences as $key => $experience) {
            $experienceCode = $this->generateCode();
            $_SESSION['experience_ids'][$experienceCode] = $experience['experience_id'];
            $experiences[$key]['experience_id'] = $experienceCode;

            foreach (['weather_id', 'road_id', 'traffic_id', 'navigation_id'] as $field) {
                if (is_array($experience[$field])) {
                    foreach ($experience[$field] as &$value) {
                        $value = $this->generateCode();
                        $_SESSION["{$field}s"][$value] = $value;
                    }
                } else {
                    $experience[$field] = $this->generateCode();
                    $_SESSION["{$field}s"][$experience[$field]] = $experience[$field];
                }
            }

            $assosiatedManeuvers = $experienceManeuverModel->getAssociatedManeuvers($experience['experience_id']);
            $experiences[$key]['maneuver_id'] = array_map(function($maneuver) {
                $maneuverCode = $this->generateCode();
                $_SESSION['maneuver_ids'][$maneuverCode] = $maneuver['maneuver_id'];
                return $maneuverCode;
            }, $assosiatedManeuvers);
        }

        if ($totalDistance == null) {
            $totalDistance = "0";
        }

        $data = [
            'experiences' => $experiences,
            'totalDistance' => $totalDistance,
            'weatherOptions' => $weatherOptions,
            'roadTypeOptions' => $roadTypeOptions,
            'trafficOptions' => $trafficOptions,
            'navigationTypeOptions' => $navigationTypeOptions,
            'maneuvers' => $maneuvers
        ];

        echo View::render('dashboard', $data);
    }

    public function reset() {
        $experienceModel = new Experience();
        $experienceModel->resetExperiences();
        header('Location: /dashboard');
    }
}