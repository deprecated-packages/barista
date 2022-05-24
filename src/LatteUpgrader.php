<?php

declare(strict_types=1);

namespace Barista;

use Barista\Contract\LatteUpgraderInterface;

/**
 * @see \Barista\Tests\LatteUpgrader\LatteUpgraderTest
 */
final class LatteUpgrader
{
    /**
     * @param LatteUpgraderInterface[] $latteSyntaxUpgraders
     */
    public function __construct(
        private array $latteSyntaxUpgraders
    ) {
    }

    public function upgradeFileContent(string $fileContent): string
    {
        foreach ($this->latteSyntaxUpgraders as $latteSyntaxUpgrader) {
            $fileContent = $latteSyntaxUpgrader->upgrade($fileContent);
        }

        return $fileContent;
    }
}
