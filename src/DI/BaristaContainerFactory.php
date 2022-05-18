<?php

declare(strict_types=1);

namespace Barista\DI;

use Nette\Bootstrap\Configurator;
use Nette\DI\Container;

final class BaristaContainerFactory
{
    public function create(): Container
    {
        $configurator = new Configurator();

        $configurator->setTempDirectory(sys_get_temp_dir() . '/barista');
        $configurator->addConfig(__DIR__ . '/../../config/services.neon');

        return $configurator->createContainer();
    }
}
