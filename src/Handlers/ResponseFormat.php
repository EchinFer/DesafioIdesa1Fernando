<?php 
namespace App\Handlers;
use Psr\Http\Message\ResponseInterface as Response;
class ResponseFormat{


    public static function successResponse(Response $response, array | bool $payload = [], string $message = "", int $statusCode = 200): Response
    {
        $payload = is_array($payload) ? $payload : [];
        $body = array(
            "success" => true,
            "message" => $message,
            "data" => $payload
        );
        $response->getBody()->write(json_encode($body));
        $response = $response->withStatus($statusCode);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    }

    public static function successInsertResponse(Response $response, $id): Response
    {
        $payload = array(
            "id" => $id
        );
        $newResponse = self::successResponse($response, $payload, "Insertion completed!", 201);
        return $newResponse;
    }

    public static function successUpdateResponse(Response $response): Response
    {
        $newResponse = self::successResponse($response, [], "Update completed!");
        return $newResponse;
    }

    public static function successDeleteResponse(Response $response): Response
    {
        $newResponse = self::successResponse($response, [], "Delete completed!");
        return $newResponse;
    }


}