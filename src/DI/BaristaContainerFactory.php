<?php

declare(strict_types=1);

namespace Barista\DI;

use Nette\Bootstrap\Configurator;
use Nette\DI\Container;
use Nette\Utils\FileSystem;

final class BaristaContainerFactory
{
    /**
     * @param string[] $configs
     */
    public function create(array $configs = []): Container
    {
        $configurator = new Configurator();

        $temporaryDirectory = sys_get_temp_dir() . '/barista';

        // we must clean the temp directory, to rebuild the container on config change
        FileSystem::delete($temporaryDirectory);
        $configurator->setTempDirectory($temporaryDirectory);

        // for search extension to work, @see https://github.com/TomasVotruba/barista/issues/3#issuecomment-1142402324
        $configurator->addParameters(['srcDir' => __DIR__ . '/../../src']);

        $configurator->addConfig(__DIR__ . '/../../config/services.neon');

        foreach ($configs as $config) {
            $configurator->addConfig($config);
        }

        return $configurator->createContainer();
    }
}
