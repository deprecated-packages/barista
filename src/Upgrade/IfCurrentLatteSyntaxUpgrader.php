<?php

declare(strict_types=1);

namespace Barista\Upgrade;

use Barista\Contract\LatteSyntaxUpgraderInterface;
use Nette\Utils\Strings;

final class IfCurrentLatteSyntaxUpgrader implements LatteSyntaxUpgraderInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/YctraT/1
     */
    private const IF_CURRENT_REGEX = '#\{ifCurrent (?<condition>.*?)\}(?<content>.*?)\{\/ifCurrent\}#m';

    public function upgrade(string $fileContent): string
    {
        return Strings::replace(
            $fileContent,
            self::IF_CURRENT_REGEX,
            function (array $match): string {
                return sprintf("{if isLinkCurrent('%s')}%s{/if}", $match['condition'], $match['content']);
            }
        );
    }
}
