<?php

require(__DIR__ . '/../vendor/autoload.php');

use App\Handlers\ErrorRenderer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/.."); 
$dotenv->safeLoad();//safe load por si no esté el archivo .env


$app = require __DIR__ . '/../app/container.php';


//Set up ErrorHandler
$app->addRoutingMiddleware();

//Add Error Middleware
$customErrorHandler = require __DIR__ . '/../src/Handlers/ErrorHandler.php';
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);

//Para parsear el body en el request
$app->addBodyParsingMiddleware();

//Registrar middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);


//Configuracion base de datos
$db = require __DIR__ . '/../app/database.php';
$db($container);

// Configurar rutas
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();
