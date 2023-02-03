<?php

namespace App\Controllers;

use App\Tools;
use \PDO;
use DI\Container;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class User
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function add(Request $request, Response $response)
    {

        $params = array();


        $respObject = array(
            "ss" => "add"
        );
        $response->getBody()->write(json_encode($respObject));
        return $response;
    }

    public function update(Request $request, Response $response)
    {

        $params = array();

        $respObject = array(
            "ss" => 'update'
        );
        $response->getBody()->write(json_encode($respObject));
        return $response;
    }


    public function delete(Request $request, Response $response)
    {


        $params = array();

        $respObject = array(
            "ss" => 'delete'
        );
        $response->getBody()->write(json_encode($respObject));
        return $response;
    }



    public function all(Request $request, Response $response)
    {

        $params = array();

        // throw new Exception("Error Processing Request");

        $jwt = Tools::vcal();

        $db = $this->container->get('db');
        $sth  = $db->prepare("SELECT * FROM book");
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);


        $respObject = array(
            "ss" => $jwt
        );
        $response->getBody()->write(json_encode($respObject));
        return $response;
    }

    public function getById(Request $request, Response $response)
    {

        $params = array();

        $respObject = array(
            "ss" => 'getById'
        );
        $response->getBody()->write(json_encode($respObject));
        return $response;
    }

}
