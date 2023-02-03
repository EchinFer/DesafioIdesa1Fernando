<?php

use App\Controllers\Book;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->group('/book', function (group $group) {

        //Get books
        $group->get('/', [Book::class, 'getAll']); //
        $group->get('/all', [Book::class, 'getAll']); //
        $group->get('/{id}', [Book::class, 'getById']); //

        //Add Books
        $group->post('/add', [Book::class, 'add']); //

        //Update book by id
        $group->put('/update/{id}', [Book::class, 'update']); //

        //Delete book by id
        $group->delete('/delete/{id}', [Book::class, 'delete']); //

    });
};
