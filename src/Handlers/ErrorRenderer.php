<?php

namespace App\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class ErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string {
        $error = array(
            "success" => false,
            "message" => $exception->getMessage(),
            "error_code" => 1308,
            "data" => []
        );
        return json_encode($error);
    }
}
