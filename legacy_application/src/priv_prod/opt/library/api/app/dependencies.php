<?php
declare(strict_types=1);

use DPR\API\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use DPR\API\Domain\UbidotsAPI;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use DPR\API\Infrastructure\Persistence\DBPool;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        DBPool::class => function(ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $dbSettings = $settings->get('database');
            return new DBPool($dbSettings);
        },
        UbidotsAPI::class => function(ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $githubSettings = $settings->get('ubidots');
            return new UbidotsAPI($githubSettings);
        },
    ]);
};
