<?php

namespace App\Controllers;

use App\Database\SqliteDb;
use App\Tools;
use App\Handlers\ResponseFormat;
use DI\Container;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Lote
{

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    public function getAll(Request $request, Response $response)
    {
        $result = SqliteDb::fetch("SELECT * FROM debts");

        $response = ResponseFormat::successResponse($response, $result);
        return $response;
    }

    public function getById(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        if (!is_numeric($id)) {
            throw new Exception("Value of the parameter 'id' is invalid");
        }
        $result = SqliteDb::fetch("SELECT * FROM debts WHERE id='{$id}'");

        $response = ResponseFormat::successResponse($response, $result);
        return $response;
    }
}
