<?php
require '../vendor/autoload.php';
use Slim\App;

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Instantiate the app
$settings = require __DIR__ . '/../app/config/settings.php';
$app = new App($settings);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/config/dependencies.php';
$dependencies($app);

//// Register middleware
//$middleware = require __DIR__ . '/../app/config/middleware.php';
//$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/config/routes.php';
$routes($app);

$app->run();