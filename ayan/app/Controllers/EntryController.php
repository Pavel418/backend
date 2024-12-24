<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Experience;
use App\Models\ExperienceManeuver;
use App\Models\Weather;
use App\Models\Road;
use App\Models\Traffic;
use App\Models\Navigation;
use App\Models\Maneuver;

class EntryController {
    public function get() {
        $weatherModel = new Weather();
        $weatherOptions = $weatherModel->getAllWeather();

        $roadModel = new Road();
        $roadOptions = $roadModel->getAllRoads();

        $trafficModel = new Traffic();
        $trafficOptions = $trafficModel->getAllTraffic();

        $navigationModel = new Navigation();
        $navigationOptions = $navigationModel->getAllNavigations();

        $maneuverModel = new Maneuver();
        $maneuverOptions = $maneuverModel->getAllManeuvers();

        $experience = new Experience();
        $totalKms = $experience->getTotalKms();

        $data = [
            'weatherOptions' => $weatherOptions,
            'roadOptions' => $roadOptions,
            'trafficOptions' => $trafficOptions,
            'navigationOptions' => $navigationOptions,
            'maneuverOptions' => $maneuverOptions,
            'totalKms' => $totalKms,
        ];

        echo View::render('form', $data);
    }

    public function post() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'];
            $start_time = $_POST['start-time'];
            $end_time = $_POST['end-time'];
            $distance = $_POST['km'];
            $navigation_id = $_POST['navigation-type'];
            $weather_id = $_POST['weather-condition'];
            $road_id = $_POST['road-type'];
            $traffic_id = $_POST['traffic-type'];
            $maneuvers = isset($_POST['maneuvers']) ? $_POST['maneuvers'] : [];

            $experience = new Experience();
            $experienceManeuver = new ExperienceManeuver();

            if ($experience->create($date, $start_time, $end_time, $distance, $navigation_id, $road_id, $traffic_id, $weather_id)) {
                $experience_id = $experience->getLastInsertId();

                foreach ($maneuvers as $maneuver_id) {
                    $experienceManeuver->associateExperienceWithManeuver($experience_id, $maneuver_id);
                }

                $_SESSION['message'] = "Experience successfully added and maneuvers associated!";
            } else {
                $_SESSION['message'] = "Failed to add experience. Please try again.";
            }

            header('Location: /dashboard');
            exit();
        }
    }

    public function edit_get($id) {
        $experience = new Experience();
        $experienceData = $experience->getExperience($id);

        $experienceManeuver = new ExperienceManeuver();
        $associatedManeuvers = $experienceManeuver->getAssociatedManeuvers($id);
        $maneuverIds = array_column($associatedManeuvers, 'maneuver_id');

        $weatherModel = new Weather();
        $weatherOptions = $weatherModel->getAllWeather();

        $roadModel = new Road();
        $roadOptions = $roadModel->getAllRoads();

        $trafficModel = new Traffic();
        $trafficOptions = $trafficModel->getAllTraffic();

        $navigationModel = new Navigation();
        $navigationOptions = $navigationModel->getAllNavigations();

        $maneuverModel = new Maneuver();
        $maneuverOptions = $maneuverModel->getAllManeuvers();

        $data = [
            'id' => $experienceData['experience_id'],
            'date' => $experienceData['date'],
            'depart_time' => $experienceData['depart_time'],
            'arrival_time' => $experienceData['arrival_time'],
            'distance' => $experienceData['distance'],
            'weather_id' => $experienceData['weather_id'],
            'road_id' => $experienceData['road_id'],
            'traffic_id' => $experienceData['traffic_id'],
            'navigation_id' => $experienceData['navigation_id'],
            'associatedManeuvers' => $maneuverIds,
            'weatherOptions' => $weatherOptions,
            'roadOptions' => $roadOptions,
            'trafficOptions' => $trafficOptions,
            'navigationOptions' => $navigationOptions,
            'maneuverOptions' => $maneuverOptions,
        ];

        echo View::render('edit', $data);
    }

    public function edit_post() {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $start_time = $_POST['start-time'];
        $end_time = $_POST['end-time'];
        $distance = $_POST['km'];
        $navigation_id = $_POST['navigation-type'];
        $weather_id = $_POST['weather-condition'];
        $road_id = $_POST['road-type'];
        $traffic_id = $_POST['traffic-type'];
        $maneuvers = isset($_POST['maneuvers']) ? $_POST['maneuvers'] : [];

        $experience = new Experience();
        $experienceManeuver = new ExperienceManeuver();

        if ($experience->update($id, $date, $start_time, $end_time, $distance, $navigation_id, $road_id, $traffic_id, $weather_id)) {
            $experienceManeuver->dissociateExperienceWithAllManeuvers($id);

            foreach ($maneuvers as $maneuver_id) {
                $experienceManeuver->associateExperienceWithManeuver($id, $maneuver_id);
            }
        }

        header('Location: /dashboard');
        exit();
    }
}
