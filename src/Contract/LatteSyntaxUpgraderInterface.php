<?php

declare(strict_types=1);

namespace Barista\Contract;

interface LatteSyntaxUpgraderInterface
{
    public function upgrade(string $fileContent): string;
}
