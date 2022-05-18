<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Barista\DI\BaristaContainerFactory;
use Symfony\Component\Console\Application;

$baristaContainerFactory = new BaristaContainerFactory();
$container = $baristaContainerFactory->create();

$application = $container->getByType(Application::class);
$resultCode = $application->run();

exit($resultCode);
