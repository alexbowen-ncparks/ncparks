<?php
namespace DPR\API\Application\Routes;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

require(__DIR__.'/../Actions/Auth/auth.php');

class AuthRoutes {

  function __invoke(RouteCollectorProxy $group) {
    // Verifies a user login and returns their JWT token.
    $group->post('/token', function (Request $request, Response $response) {
        return getToken($request, $response);
    });

  }
}