<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\Container;

// Create Container using PHP-DI
$container = new Container();

// Set container to create App with on AppFactory
AppFactory::setContainer($container);
return AppFactory::create();
