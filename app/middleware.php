<?php

declare(strict_types=1);

use Slim\App;

use Tuupola\Middleware\JwtAuthentication;

return function (App $app) {
    $app->add(new JwtAuthentication([
        "secret" => $_ENV["SECRET_AUTH_KEY"],
        "error" => function ($response, $arguments) {
            // $data["status"] = "error";
            // $data["message"] = $arguments["message"];

            $statusCode = 401;
            $error = array(
                "success" => false,
                "message" => $arguments["message"],
                "data" => []
            );


            $response->getBody()->write(
                json_encode($error, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            );

            return $response
                ->withStatus($statusCode)
                ->withHeader('Content-type', 'application/json');
        }
    ]));
};
