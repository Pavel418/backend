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

class FormController {
    
    public function index() {
        // Retrieve the options for select inputs
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

        // Pass the data to the view
        $data = [
            'weatherOptions' => $weatherOptions,
            'roadOptions' => $roadOptions,
            'trafficOptions' => $trafficOptions,
            'navigationOptions' => $navigationOptions,
            'maneuverOptions' => $maneuverOptions,
            'totalKms' => $totalKms,
        ];

        // Render the form view
        echo View::render('form', $data);
    }

    public function store() {
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather POST data
            $date = $_POST['date'];
            $start_time = $_POST['start-time'];
            $end_time = $_POST['end-time'];
            $distance = $_POST['km'];
            $navigation_id = $_POST['navigation-type'];
            $weather_id = $_POST['weather-condition'];
            $road_id = $_POST['road-type'];
            $traffic_id = $_POST['traffic-type'];
            $maneuvers = isset($_POST['maneuvers']) ? $_POST['maneuvers'] : [];

            // Instantiate the models
            $experience = new Experience();
            $experienceManeuver = new ExperienceManeuver();

            // Attempt to save the experience
            if ($experience->create($date, $start_time, $end_time, $distance, $navigation_id, $road_id, $traffic_id, $weather_id)) {
                $experience_id = $experience->getLastInsertId();

                // Associate maneuvers with the experience
                foreach ($maneuvers as $maneuver_id) {
                    $experienceManeuver->associateExperienceWithManeuver($experience_id, $maneuver_id);
                }

                // Set a success message
                $_SESSION['message'] = "Experience successfully added and maneuvers associated!";
            } else {
                // Set an error message
                $_SESSION['message'] = "Failed to add experience. Please try again.";
            }

            // Redirect back to the form
            header('Location: /form');
            exit();
        }
    }
}
