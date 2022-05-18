<?php

declare(strict_types=1);

namespace Barista\DI;

use Nette\Bootstrap\Configurator;
use Nette\DI\Container;

final class BaristaContainerFactory
{
    /**
     * @param string[] $configs
     */
    public function create(array $configs = []): Container
    {
        $configurator = new Configurator();

        $configurator->setTempDirectory(sys_get_temp_dir() . '/barista');
        $configurator->addConfig(__DIR__ . '/../../config/services.neon');

        foreach ($configs as $config) {
            $configurator->addConfig($config);
        }

        return $configurator->createContainer();
    }
}
