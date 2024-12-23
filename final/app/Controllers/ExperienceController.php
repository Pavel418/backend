<?php

namespace App\Controllers;

use App\Models\Experience;
use App\Models\Navigation;
use App\Models\Road;
use App\Models\Traffic;
use App\Models\Weather;

class ExperienceController
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

    public function getNavigationMonthlyData()
    {
        $data = $this->experienceModel->getMonthlyNavigationData();
        echo json_encode($data);
    }

    public function getTrafficMonthlyData()
    {
        $data = $this->experienceModel->getMonthlyTrafficData();
        echo json_encode($data);
    }

    public function getWeatherDistributionData()
    {
        $data = $this->experienceModel->getMonthlyWeatherData();
        echo json_encode($data);
    }

    public function getRoadMonthlyData()
    {
        $data = $this->experienceModel->getMonthlyRoadData();
        echo json_encode($data);
    }

    public function getTripDistanceData()
    {
        $data = $this->experienceModel->getTripDistances();
        echo json_encode($data);
    }

    public function getHeatmapData()
    {
        $data = $this->experienceModel->getHeatmapData();
        echo json_encode($data);
    }
}
