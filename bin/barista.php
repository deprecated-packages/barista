<?php

declare(strict_types=1);

$autoloadPaths = [
    // dev package
    __DIR__ . '/../vendor/autoload.php',
    // dependency
    __DIR__ . '/../../../../vendor/autoload.php',
];

foreach ($autoloadPaths as $autoloadPath) {
    if (file_exists($autoloadPath)) {
        require_once $autoloadPath;
        break;
    }
}

use Barista\DI\BaristaContainerFactory;
use Symfony\Component\Console\Application;

// load with custom config
$rootBaristaConfig = getcwd() . '/barista.neon';

$configs = [];
if (file_exists($rootBaristaConfig)) {
    $configs[] = $rootBaristaConfig;
}

$baristaContainerFactory = new BaristaContainerFactory();
$container = $baristaContainerFactory->create($configs);

$application = $container->getByType(Application::class);
$resultCode = $application->run();

exit($resultCode);
