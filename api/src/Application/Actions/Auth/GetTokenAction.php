<?php
declare(strict_types=1);

namespace DPR\API\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;

use DPR\API\Application\Actions\Action;

class GetTokenAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->request;
        $response = $this->response;

        $response = $this->DAOFactory->ExampleDAO->getToken($request, $response);

        $this->logger->info("User attempted login.");

        return $response;
    }
}
