<?php
namespace DPR\API\Application\Routes;

use Slim\Routing\RouteCollectorProxy;
use DPR\API\Application\Actions\Auth\GetTokenAction;

class AuthRoutes {

  function __invoke(RouteCollectorProxy $group) {
    // Verifies a user login and returns their JWT token.
    $group->post('/token', GetTokenAction::class);

  }
}