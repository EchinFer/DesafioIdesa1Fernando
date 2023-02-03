<?php

namespace App\Controllers;

use App\Tools;
use App\Handlers\ResponseFormat;

use \PDO;
use DI\Container;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Book
{

    private Container $container;
    private PDO $db;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $this->container->get('db');
    }

    public function add(Request $request, Response $response)
    {
        $params = (array)$request->getParsedBody();

        $validateParams = Tools::validateRequiredParams(['title', 'publisher_id', 'author_id'], $params);

        if (!$validateParams) {
            throw new Exception('Missing required parameters in the request');
        }

        $title = $params['title'];
        $rating = $params['rating'] ?? 0;
        $publisher_id = $params['publisher_id'];
        $author_id = $params['author_id'];

        $bookPayload = array(
            "title" => $title,
            "rating" => $rating,
            "publisher_id" =>  $publisher_id,
            "author_id" => $author_id
        );

        if (!Tools::existForeignIdData($this->db, 'publisher', 'publisher_id', $publisher_id)) {
            throw new Exception("Invalid 'publisher id' key");
        }

        if (!Tools::existForeignIdData($this->db, 'author', 'author_id', $author_id)) {
            throw new Exception("Invalid 'author_id id' key");
        }

        $newId = 0;
        try {
            $newId = Tools::insertDb($this->db, 'book', $bookPayload);
            if (!$newId) {
                throw new Exception('Error, something happened while trying to insert the Book. Contact the provider');
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        $response = ResponseFormat::successInsertResponse($response, $newId);
        return $response;
    }

    public function update(Request $request, Response $response, $args)
    {
        $params = (array)$request->getParsedBody();
        $validateParams = Tools::validateRequiredParams(['id'], $args);

        if (!$validateParams) {
            throw new Exception('Missing required parameters in the request');
        }

        $id = $args['id'];

        $existBook = Tools::fetchDb($this->db, "SELECT * FROM book WHERE book_id = {$id}");
        if ($existBook === false) {
            throw new Exception("The Book with the 'id' does not exist");
        }


        $title = array_key_exists('title', $params) ? $params['title'] : false;
        $rating = array_key_exists('rating', $params) ? $params['rating'] : false;
        $publisher_id = array_key_exists('publisher_id', $params) ? $params['publisher_id'] : false;
        $author_id = array_key_exists('author_id', $params) ? $params['author_id'] : false;

        $bookPayload = array(
            "title" => $title,
            "rating" => $rating,
            "publisher_id" =>  $publisher_id,
            "author_id" => $author_id
        );

        $newBookPayload = array_filter($bookPayload, static function ($element) {
            return $element !== false;
        });

        if (!count($newBookPayload)) {
            throw new Exception("No parameter found to update");
        }

        if ($publisher_id !== false) {

            if (!Tools::existForeignIdData($this->db, 'publisher', 'publisher_id', $publisher_id)) {
                throw new Exception("Invalid 'publisher id' key");
            }
        }

        if ($author_id !== false) {

            if (!Tools::existForeignIdData($this->db, 'author', 'author_id', $author_id)) {
                throw new Exception("Invalid 'author_id id' key");
            }
        }

        try {
            $result = Tools::updatetDb($this->db, 'book', $newBookPayload, ['book_id' => $id]);
            if ($result === false) {
                throw new Exception('Error, something happened while trying to update the Book. Contact the provider');
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        $response = ResponseFormat::successUpdateResponse($response);
        return $response;
    }

    public function delete(Request $request, Response $response, $args)
    {

        $id = $args['id'];
        if (!is_numeric($id)) {
            throw new Exception("Value of the parameter 'id' is invalid");
        }

        $existBook = Tools::fetchDb($this->db, "SELECT * FROM book WHERE book_id = {$id}");
        if ($existBook === false) {
            throw new Exception("The Book with the 'id' does not exist");
        }

        try {
            $result = Tools::deletetDb($this->db, "book", "book_id", $id);
            if ($result === false) {
                throw new Exception('Error, something happened while trying to delete the Book. Contact the provider');
            }
        } catch (\Throwable $th) {
            throw $th;
        }


        $response = ResponseFormat::successDeleteResponse($response);
        return $response;

    }

    public function getAll(Request $request, Response $response)
    {
        // $db = $this->container->get('db');
        $result = Tools::fetchAllDb($this->db, "SELECT * FROM book");

        $response = ResponseFormat::successResponse($response, $result);
        return $response;
    }

    public function getById(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        if (!is_numeric($id)) {
            throw new Exception("Value of the parameter 'id' is invalid");
        }
        $result = Tools::fetchDb($this->db, "SELECT * FROM book WHERE book_id = '{$id}'");

        $response = ResponseFormat::successResponse($response, $result);
        return $response;
    }
}
