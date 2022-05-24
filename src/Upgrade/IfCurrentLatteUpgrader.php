<?php

declare(strict_types=1);

namespace Barista\Upgrade;

use Barista\Contract\LatteUpgraderInterface;
use Nette\Utils\Strings;

final class IfCurrentLatteUpgrader implements LatteUpgraderInterface
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
                $condition = $match['condition'];

                // remove extra quotes if used
                if (str_starts_with($condition, "'") && str_ends_with($condition, "'")) {
                    $condition = trim($condition, "'");
                    $quoteChar = "'";
                } elseif (str_starts_with($condition, '"') && str_ends_with($condition, '"')) {
                    $condition = trim($condition, '"');
                    $quoteChar = '"';
                } else {
                    // default
                    $quoteChar = "'";
                }

                return sprintf('{if isLinkCurrent(%s%s%s)}%s{/if}', $quoteChar, $condition, $quoteChar, $match['content']);
            }
        );
    }
}
