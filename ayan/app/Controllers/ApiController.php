<?php

namespace App\Controllers;

use App\Models\Experience;
use App\Models\Navigation;
use App\Models\Road;
use App\Models\Traffic;
use App\Models\Weather;

class ApiController
{
    protected $experienceModel;
    protected $navigationModel;
    protected $roadModel;
    protected $trafficModel;
    protected $weatherModel;

    public function __construct()
    {
        $this->experienceModel = new Experience();
        $this->navigationModel = new Navigation();
        $this->roadModel = new Road();
        $this->trafficModel = new Traffic();
        $this->weatherModel = new Weather();
    }

    public function getTrafficData()
    {
        $data = $this->experienceModel->getTrafficData();
        echo json_encode($data);
    }

    public function getNavigationData()
    {
        $data = $this->experienceModel->getNavigationData();
        echo json_encode($data);
    }

    public function getRoadData()
    {
        $data = $this->experienceModel->getRoadData();
        echo json_encode($data);
    }

    public function getCumulativeDistanceData()
    {
        $data = $this->experienceModel->cumulativeMonthlyDistance();
        echo json_encode($data);
    }

    public function deleteExperience()
    {
        $id = $_POST['id'];
        $deleted = $this->experienceModel->deleteExperience($id);
        
        if ($deleted) {
            http_response_code(200);
            echo json_encode(['message' => $_POST]);
            echo json_encode(['message' => 'Experience deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Experience not found']);
        }
    }

    public function addRandomData() {
        $this->experienceModel->addRandomData();
        echo header('Location: /dashboard');
    }
}
