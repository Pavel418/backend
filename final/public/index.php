<?php

use App\Core\Router;
use App\Config\Config;

require '../app/Core/Router.php';
require '../app/Controllers/HomeController.php';
require '../app/Controllers/ExperienceController.php';
require '../app/Controllers/DashboardController.php';
require '../app/Controllers/FormController.php';
require '../app/Core/View.php';
require '../app/Core/Database.php';
require '../app/Models/Experience.php';
require '../app/Models/ExperienceManeuver.php';
require '../app/Models/Weather.php';
require '../app/Models/Road.php';
require '../app/Models/Traffic.php';
require '../app/Models/Maneuver.php';
require '../app/Models/Navigation.php';
require '../app/Config/Config.php';

$router = new Router();
// Config::loadEnv('../.env');

$router->get('/', 'HomeController@index');
$router->get('/dashboard', 'DashboardController@index');
$router->get('/form', 'FormController@index');

$router->post('/form', 'FormController@store');

$router->get('/dashboard/reset', 'DashboardController@reset');

$router->get('/api/navigation/monthly', 'ExperienceController@getNavigationMonthlyData');
$router->get('/api/traffic/monthly', 'ExperienceController@getTrafficMonthlyData');
$router->get('/api/weather/distribution', 'ExperienceController@getWeatherDistributionData');
$router->get('/api/road/monthly', 'ExperienceController@getRoadMonthlyData');
$router->get('/api/trips/distances', 'ExperienceController@getTripDistanceData');
$router->get('/api/categories/heatmap', 'ExperienceController@getHeatmapData');

$router->dispatch($_SERVER['REQUEST_URI']);