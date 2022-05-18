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

$baristaContainerFactory = new BaristaContainerFactory();
$container = $baristaContainerFactory->create();

$application = $container->getByType(Application::class);
$resultCode = $application->run();

exit($resultCode);
