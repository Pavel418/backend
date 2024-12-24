<?php

use App\Core\Router;

require '../app/Core/Router.php';
require '../app/Controllers/LandingController.php';
require '../app/Controllers/EntryController.php';
require '../app/Controllers/SummaryController.php';
require '../app/Controllers/ApiController.php';
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

$router->get('/', 'LandingController@get');
$router->get('/summary', 'SummaryController@get');
$router->get('/summary/reset', 'SummaryController@reset');

$router->get('/entry', 'EntryController@get');
$router->post('/entry', 'EntryController@post');

$router->get('/experience/edit', 'EntryController@edit_get');
$router->post('/experience/edit', 'EntryController@edit_post');
$router->get('/experience/random', 'ApiController@addRandomData');

$router->get('/api/navigation', 'ApiController@getNavigationData');
$router->get('/api/traffic', 'ApiController@getTrafficData');
$router->get('/api/road', 'ApiController@getRoadData');
$router->get('/api/distance', 'ApiController@getCumulativeDistanceData');
$router->post('/api/experience/delete', 'ApiController@deleteExperience');

$router->dispatch($_SERVER['REQUEST_URI']);