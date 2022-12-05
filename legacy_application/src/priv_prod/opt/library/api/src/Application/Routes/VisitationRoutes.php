<?php
namespace DPR\API\Application\Routes;

use DPR\API\Application\Actions\Visitation\Devices\GetDevicesAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;


class VisitationRoutes {

  function __invoke(RouteCollectorProxy $group) {

    $group->get('/devices', GetDevicesAction::class);

  }
}