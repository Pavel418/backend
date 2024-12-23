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
    public function index() {
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
            $assosiatedManeuvers = $experienceManeuverModel->getAssociatedManeuvers($experience['experience_id']);
            $experiences[$key]['maneuver_id'] = array_map(function($maneuver) {
                return $maneuver['maneuver_id'];
            }, $assosiatedManeuvers);
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