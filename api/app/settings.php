<?php

declare(strict_types=1);

use DPR\API\Application\Settings\Settings;
use DPR\API\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

  // Global Settings Object
  $containerBuilder->addDefinitions([
    SettingsInterface::class => function () {
      return new Settings([
        'displayErrorDetails' => true, // Should be set to false in production
        'logError'            => true,
        'logErrorDetails'     => true,
        'logger' => [
          'name' => 'DPR-API',
          'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
          'level' => Logger::DEBUG,
        ],
        'database' => [
          'engine' => getenv('DB_ENGINE') ?? null,
          'host' => getenv('DB_HOST') ?? null,
          'port' => getenv('DB_PORT') ?? null,
          'dbname' => getenv('DB_NAME') ?? null,
          'user' => getenv('DB_USER') ?? null,
          'password' => getenv('DB_PASSWORD') ?? null,
          'charset' => getenv('DB_CHARSET') ?? null,
        ],
        'ubidots' => [
          'api_key' => getenv('UBIDOTS_API_KEY') ?? '',
        ]
      ]);
    }
  ]);
};
