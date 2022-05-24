<?php

declare(strict_types=1);

namespace Barista\Contract;

interface LatteUpgraderInterface
{
    public function upgrade(string $fileContent): string;
}
