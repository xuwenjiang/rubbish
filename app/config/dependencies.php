<?php

use Slim\App;
use Slim\Http\Environment;
use Slim\Views\TwigExtension;
use Slim\Views\Twig;
use Slim\Http\Uri;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;

return function (App $app) {

    $container = $app->getContainer();

    // monolog
    $container['logger'] = function ($container) {
        $settings = $container->get('settings')['logger'];
        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container['view'] = function ($container) {
        $view =new \Slim\Views\PhpRenderer("../app/templates/");
        return $view;
    };

    $container['db'] = function ($container) {
        $db = $container->get('settings')['db'];$pdo = new PDO('mysql:host=' . $db['host'] .';port=' . $db['port'] .';dbname=' . $db['dbname'], $db['user'], $db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    };
};
