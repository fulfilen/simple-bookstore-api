<?php 
namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class HomeController
{
    public function index(Request $request, Response $response, array $args)
    {
        var_dump(range(1,5));
        $response->getBody()->write("Hello X, Welcome");

    return $response;
    }
}