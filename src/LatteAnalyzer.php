<?php

declare(strict_types=1);

namespace Barista;

use Barista\LatteParser\LatteParser;
use Nette\Utils\FileSystem;

final class LatteAnalyzer
{
    public function __construct(
        private LatteParser $latteParser,
    ) {
    }

    /**
     * @param string[] $filePaths
     */
    public function run(array $filePaths)
    {
        foreach ($filePaths as $file) {
            $fileContent = FileSystem::read($file);
            $templateNode = $this->latteParser->parseCode($fileContent);

            dump($templateNode);
        }

        // @todo add latte node visitor
    }
}
