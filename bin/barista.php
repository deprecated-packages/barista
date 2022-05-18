<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Barista\Analyzer\LatteAnalyzer;
use Barista\DI\BaristaContainerFactory;

$baristaContainerFactory = new BaristaContainerFactory();
$container = $baristaContainerFactory->create();

$commandNames = $container->findByType(\Symfony\Component\Console\Command\Command::class);
$commands = [];
foreach ($commandNames as $commandName) {
    $commands[] = $container->getByName($commandName);
}

$application = new \Symfony\Component\Console\Application();
$application->addCommands($commands);
$application->run();

//$latteAnalyzer = $container->getByType(LatteAnalyzer::class);
//
//$inputArgs = $argv;
//array_shift($inputArgs);
//
//$filePaths = $inputArgs;
//
//if ($filePaths === []) {
//    exit('Provide file/dir paths to analyze' . PHP_EOL);
//}
//
//$result = $latteAnalyzer->run($filePaths);
//exit($result);
