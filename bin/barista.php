<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Barista\Analyzer\LatteAnalyzer;
use Barista\DI\BaristaContainerFactory;

$baristaContainerFactory = new BaristaContainerFactory();
$container = $baristaContainerFactory->create();

$latteAnalyzer = $container->getByType(LatteAnalyzer::class);

$inputArgs = $argv;
array_shift($inputArgs);

$filePaths = $inputArgs;

$result = $latteAnalyzer->run($filePaths);
exit($result);
