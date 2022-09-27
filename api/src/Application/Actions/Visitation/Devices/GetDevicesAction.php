<?php
declare(strict_types=1);

namespace DPR\API\Application\Actions\Visitation\Devices;

use Psr\Http\Message\ResponseInterface as Response;

use DPR\API\Application\Actions\Visitation\VisitationAction;

class GetDevicesAction extends VisitationAction
{
  /**
   * {@inheritdoc}
   */
  protected function action(): Response
  {
    $result = [
      'devices' => $this->ubidotsAPI->getDevices()
    ];

    $this->logger->info("Users list was viewed.");

    return $this->respondWithData($result);
  }
}
