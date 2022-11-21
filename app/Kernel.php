<?php declare(strict_types=1);

namespace App;

use Contributte\Bootstrap\ExtraConfigurator;

class Kernel
{
  public static function boot(): ExtraConfigurator
  {
    $configurator = new ExtraConfigurator();
    $appDir = dirname(__DIR__);

    $configurator->setEnvDebugMode();

    $configurator->enableTracy($appDir . '/log');

    $configurator->setTimeZone('Europe/Prague');
    $configurator->setTempDirectory($appDir . '/temp');

    $configurator->createRobotLoader()
      ->addDirectory(__DIR__)
      ->register();

    $configurator->addConfig($appDir . '/config/common.neon');
    $configurator->addConfig($appDir . '/config/services.neon');
    $configurator->addConfig($appDir . '/config/local.neon');

    return $configurator;
  }
}
