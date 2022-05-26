<?php

declare(strict_types=1);

namespace Barista\Upgrade;

use Barista\Contract\LatteUpgraderInterface;
use Nette\Utils\Strings;

final class DoubleToSingleTranslateLatteUpgrader implements LatteUpgraderInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/oIrbud/1
     */
    private const UNDERSCORE_REGEX = '#\{_\}(?<content>.*?)\{\/_\}#m';

    public function upgrade(string $fileContent): string
    {
        $fileContent = Strings::replace(
            $fileContent,
            self::UNDERSCORE_REGEX,
            function (array $match): string {
                $content = $match['content'];
                $content = Strings::replace($content, '#\"#', '\\\\"');

                return sprintf('{_"%s"}', $content);
            }
        );

        // clear javascript double quotes
        return Strings::replace($fileContent, '#(?<open><script.*?>)(?<javascript_content>.*?)(?<close><\/script>)#ms', function (array $match) {
            $content = Strings::replace($match['javascript_content'], '#"(?<translate_content>{_"(.*?)"})"#', '$1');

            return $match['open'] . $content . $match['close'];
        });
    }
}
