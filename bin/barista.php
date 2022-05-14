<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Barista\LatteAnalyzer;
use Barista\LatteParser\LatteParser;

$latteAnalyzer = new LatteAnalyzer(new LatteParser());
$latteAnalyzer->run([
    __DIR__ . '/../fixture/a-with-attributes.latte',
    __DIR__ . '/../fixture/with-variable-inside.latte',
]);
