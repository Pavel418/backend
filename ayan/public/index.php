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

$router->get('/api/navigation', 'ExperienceController@getNavigationData');
$router->get('/api/traffic', 'ExperienceController@getTrafficData');
$router->get('/api/road', 'ExperienceController@getRoadData');
$router->get('/api/distance', 'ExperienceController@getCumulativeDistanceData');

$router->post('/api/experience/delete', 'ExperienceController@deleteExperience');

$router->get('/experience/edit', 'FormController@edit');
$router->post('/experience/edit', 'FormController@post_edit');
$router->get('/experience/random', 'ExperienceController@addRandomData');

$router->dispatch($_SERVER['REQUEST_URI']);