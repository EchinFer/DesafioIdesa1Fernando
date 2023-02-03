<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

$customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
) use ($app) {
    $statusCode = 500;
    
    //Condición por si se retorna un status personalizado al generar el error
    if (is_int($exception->getCode()) &&  $exception->getCode() >= 400 && $exception->getCode() <= 500) {
        $statusCode = $exception->getCode();
    }
    $secret = base64_encode( "este es mi palabra secreta para jwt" );
    $error = array(
        "success" => false,
        "message" => $exception->getMessage(),
        "data" => []
    );

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($error, JSON_UNESCAPED_UNICODE)
    );

    return $response
        ->withStatus($statusCode)
        ->withHeader('Content-type', 'application/json');
};


return $customErrorHandler;
