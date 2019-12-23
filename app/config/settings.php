<?php

use Monolog\Logger;

return [
    'settings' => [
        'debug' => true,
        'mode' => 'development',

        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],

        'db' => [
            'host' => 'db',
            'port' => '3306',
            'user' => 'user',
            'pass' => 'pass',
            'dbname' => 'exercise'
        ],
    ],
];
